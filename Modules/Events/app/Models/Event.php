<?php

namespace Modules\Events\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use LaravelArchivable\Archivable;
use LaravelPublishable\Publishable;
use Modules\Events\Data\Link;
use Modules\Events\Database\Factories\EventFactory;
use Modules\Events\Exceptions\InvalidLink;
use Spatie\Translatable\HasTranslations;

class Event extends Model
{
    use Archivable;
    use HasFactory;
    use HasTranslations;
    use Publishable;
    use SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'name', 'start_date', 'end_date',
        'description', 'url', 'image_path',
        'category', 'organisation_id', 'place_id',
        'extras', 'published_at', 'scheduled_at',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'scheduled_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'extras' => AsCollection::class,
    ];

    public $appends = ['attendance_mode', 'duration', 'is_online'];

    public array $translatable = ['name', 'description', 'category'];

    public const string ATTENDANCE_MIXED = 'mixed';

    public const string ATTENDANCE_OFFLINE = 'offline';

    public const string ATTENDANCE_ONLINE = 'online';

    public function toArray(): array
    {
        $attributes = parent::toArray();

        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }

        return $attributes;
    }

    protected static function newFactory(): EventFactory
    {
        return EventFactory::new();
    }

    /**
     * Returns a data string ics format of the event.
     * This can be used to download an ics file.
     */
    public function ics(): string
    {
        $start_date = $this->start_date;
        $end_date = $this->end_date;

        if ($start_date == null) {
            throw InvalidLink::noStartDateProvided();
        } elseif ($end_date == null) {
            $end_date = $start_date->addMinutes(config('events.event_default_duration'));
        }

        $link = Link::create($this->name, $start_date, $end_date)
            ->description($this->description);

        return $link->ics();
    }

    public function jsonLd(): array
    {
        $attendanceModeSchema = 'https://schema.org/OfflineEventAttendanceMode';

        if ($this->attendance_mode == self::ATTENDANCE_ONLINE) {
            $attendanceModeSchema = 'https://schema.org/OnlineEventAttendanceMode';
        } elseif ($this->attendance_mode == self::ATTENDANCE_MIXED) {
            $attendanceModeSchema = 'https://schema.org/MixedEventAttendanceMode';
        }

        return [
            '@type' => 'Event',
            'name' => $this->name,
            'startDate' => $this->start_date ? $this->start_date->tz('UTC')->toAtomString() : null,
            'endDate' => $this->end_date ? $this->end_date->tz('UTC')->toAtomString() : null,
            'eventStatus' => $this->cancelled_at == null ? 'https://schema.org/EventScheduled' : 'https://schema.org/EventCancelled',
            'eventAttendanceMode' => $attendanceModeSchema,
            'description' => $this->description,
        ];
    }

    public function getAttendanceModeAttribute()
    {
        return $this->extras?->get('attendance_mode', null);
    }

    public function setAttendanceModeAttribute($value): void
    {
        if (! collect([self::ATTENDANCE_MIXED, self::ATTENDANCE_OFFLINE, self::ATTENDANCE_ONLINE])->contains($value)) {
            throw new Exception('Attendance mode unknown. Only offline, online and mixed is allowed.');
        }

        if ($this->extras) {
            $this->extras->put('attendance_mode', $value);
        } else {
            $this->extras = collect(['attendance_mode' => $value]);
        }
    }

    public function getDurationAttribute(): ?int
    {
        if ($this->start_date && $this->end_date) {
            return abs($this->end_date->diffInMinutes($this->start_date));
        } elseif ($this->start_date) {
            return config('events.event_default_duration', 30);
        } else {
            return null;
        }
    }

    public function getIsOnlineAttribute(): bool
    {
        if ($this->extras) {
            return Str::contains(Str::lower($this->extras->get('location', '')), 'online');
        }

        return false;
    }

    public function ticketAssignments(): BelongsToMany
    {
        return $this->belongsToMany(
            Ticket::class,
            'ticket_assignments'
        )->using(TicketAssignment::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header');
    }

    public function isActive(): bool
    {
        $now = \Illuminate\Support\Carbon::now()->toDateTimeString();
        $deadline = Carbon::now()
            ->addMinutes(config('mm-events.event_active_duration') * -1)
            ->toDateTimeString();

        if (
            $this->end_date == null &&
            $this->start_date != null &&
            $this->start_date <= $now &&
            $this->start_date >= $deadline
        ) {
            return true;
        }

        if ($this->end_date >= $now && $this->start_date <= $now) {
            return true;
        }

        return false;
    }

    public function scopeActive($query): Builder
    {
        $now = Carbon::now()->toDateTimeString();
        $deadline = Carbon::now()->addMinutes(config('events.event_active_duration') * -1)->toDateTimeString();

        return $query
            ->where(function ($query) use ($now, $deadline) {
                $query
                    ->where('end_date', '=', null)
                    ->where('start_date', '!=', null)
                    ->where('start_date', '<=', $now)
                    ->where('start_date', '>=', $deadline);
            })
            ->orWhere(function ($query) use ($now) {
                $query
                    ->where('end_date', '>=', $now)
                    ->where('start_date', '<=', $now);
            });
    }

    public function scopeToday(Builder $query): Builder
    {
        $now = Carbon::now()->toDateTimeString();
        $today = Carbon::today()->toDateString();

        return $query
            ->whereDate('start_date', '=', $today)
            ->orWhereDate('end_date', '=', $today)
            ->orWhere(function (Builder $query) use ($now) {
                $query
                    ->where('end_date', '>=', $now)
                    ->where('start_date', '<=', $now);
            });
    }

    /**
     * Returns all upcoming events that have a start date
     * which is greater than the current date.
     */
    public function scopeUpcomingToday(Builder $query): Builder
    {
        return $query
            ->whereDate('start_date', '=', Carbon::today()->toDateString())
            ->where('start_date', '>', Carbon::now());
    }

    /**
     * Returns all events that take place in the future
     * after tomorrow or have no start date set.
     */
    public function scopeNextDays(Builder $query): Builder
    {
        $today = Carbon::today()->toDateString();

        return $query
            ->whereDate('start_date', '>', $today)
            ->orWhere('start_date', '=', null);
    }

    /**
     * Orders the query with a chronological start date.
     * Events without a start date go last.
     */
    public function scopeChronological(Builder $query): Builder
    {
        $driver = $query->getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            return $query->orderByRaw('start_date ASC NULLS LAST');
        }

        return $query
            ->orderByRaw('-start_date DESC');
    }

    /**
     * Returns all events that have a start date greater than today.
     */
    public function scopeFuture(Builder $query): Builder
    {
        return $query
            ->whereDate('start_date', '>=', now()->toDateString())
            ->orWhere('start_date', '=', null);
    }

    public function scopePast(Builder $query): Builder
    {
        return $query
            ->where('start_date', '<=', now()->toDateString());
    }

    public function scopeDrafts(Builder $query): Builder
    {
        return $query->where('published_at', '=', null);
    }

    public function scopeFilter($query, array $filters): void
    {
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        $query
            ->when($filters['search'] ?? null, function ($query, $search) use ($locale, $fallback) {
                $query
                    ->where("name->$locale", 'like', '%'.$search.'%')
                    ->orWhere("name->$fallback", 'like', '%'.$search.'%');
            })
            ->when($filters['type'] ?? null, function ($query, $type) {
                if ($type === 'upcoming') {
                    $query->future();
                } elseif ($type === 'past') {
                    $query->past();
                } elseif ($type === 'drafts') {
                    $query->drafts();
                } elseif ($type === 'archived') {
                    $query->onlyArchived();
                } elseif ($type === 'deleted') {
                    $query->onlyTrashed();
                }
            })
            ->when($filters['collection'] ?? null, function ($query, $collection) {
                $query->collection($collection);
            })
            ->when($filters['trashed'] ?? null, function ($query, $trashed) {
                if ($trashed === 'with') {
                    $query->withTrashed();
                } elseif ($trashed === 'only') {
                    $query->onlyTrashed();
                }
            })
            ->when($filters['category'] ?? null, function ($query, $category) use ($locale, $fallback) {
                $query
                    ->where("category->$locale", 'like', '%'.$category.'%')
                    ->orWhere("category->$fallback", 'like', '%'.$category.'%');
            });
    }

    public function scopeCollection(Builder $query, string $collectionName): Builder
    {
        return $query->where('extras->collection', '=', $collectionName);
    }

    public function scopeNoCollection(Builder $query): Builder
    {
        return $query->whereNull('extras->collection');
    }

    /**
     * Returns all upcoming events that have a start date
     * which is greater than now.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query
            ->where(function ($query) {
                $query->where('start_date', '>=', Carbon::now());
            });
    }

    public function scopeOnlyOnline(Builder $query): Builder
    {
        return $query
            ->where('extras->attendance_mode', self::ATTENDANCE_ONLINE);
    }

    public function scopeOnlineAndMixed(Builder $query): Builder
    {
        return $query
            ->where(function ($query) {
                $query
                    ->where('extras->attendance_mode', self::ATTENDANCE_ONLINE)
                    ->orWhere('extras->attendance_mode', self::ATTENDANCE_MIXED);
            });
    }

    public function scopeOffline(Builder $query): Builder
    {
        return $query
            ->where(function ($query) {
                $query
                    ->where('extras->attendance_mode', self::ATTENDANCE_ONLINE)
                    ->orWhere('extras->attendance_mode', null);
            });
    }

    public function scopeWithDaysDuration(Builder $builder): Builder
    {
        return $builder
            ->when(empty($builder->getQuery()->columns), fn ($q) => $q->select('*'))
            ->selectRaw('datediff(end_date, start_date) as days_duration');
    }

    public function scopeWithMinutesDuration(Builder $builder): Builder
    {
        return $builder
            ->when(empty($builder->getQuery()->columns), fn ($q) => $q->select('*'))
            ->selectRaw('TIMESTAMPDIFF(MINUTE, start_date, end_date) as minutes_duration');
    }

    public function scopeWithSecondsDuration(Builder $builder): Builder
    {
        return $builder
            ->when(empty($builder->getQuery()->columns), fn ($q) => $q->select('*'))
            ->selectRaw('TIMESTAMPDIFF(MINUTE, start_date, end_date) as seconds_duration');
    }

    public function scopeOnlyLongTermEvents(Builder $query, ?int $duration_threshold = null): Builder
    {
        if (! $duration_threshold) {
            $duration_threshold = config('mm-events.min_long_event_duration', 2 * 24 * 60 * 60);
        }

        return $query->whereRaw('TIMESTAMPDIFF(SECOND, start_date, end_date) >= ?', [$duration_threshold]);
    }

    public function scopeWithoutLongTermEvents(Builder $builder, ?int $duration_threshold = null): Builder
    {
        if (! $duration_threshold) {
            $duration_threshold = config('mm-events.min_long_event_duration', 2 * 24 * 60 * 60);
        }

        return $builder
            ->where(function ($query) {
                $query
                    ->where('start_date', '!=', null)
                    ->whereNull('end_date');
            })
            ->orWhereRaw('TIMESTAMPDIFF(SECOND, start_date, end_date) < ?', [$duration_threshold]);
    }
}
