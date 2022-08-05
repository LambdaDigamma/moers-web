<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use LambdaDigamma\MMEvents\Models\Event as BaseEvent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Event extends BaseEvent implements HasMedia
{
    use InteractsWithMedia;

    public $appends = ['is_online'];

    protected $casts = [
        'extras' => AsCollection::class,
    ];

    protected static function booted()
    {
        // static::archived(function ($event) {
        //     if ($event->page_id != null) {
        //         $page = $event
        //             ->page()
        //             ->withNotPublished()
        //             ->withArchived()
        //             ->withTrashed()
        //             ->get()
        //             ->first();
        //         $page->archive();
        //     }
        // });

        // static::unarchived(function ($event) {
        //     if ($event->page_id != null) {
        //         $page = $event
        //             ->page()
        //             ->withNotPublished()
        //             ->withArchived()
        //             ->withTrashed()
        //             ->get()
        //             ->first();
        //         $page->unArchive();
        //     }
        // });

        // static::published(function ($event) {
        //     if ($event->page_id != null) {
        //         $page = $event
        //             ->page()
        //             ->withNotPublished()
        //             ->withArchived()
        //             ->withTrashed()
        //             ->get()
        //             ->first();
        //         $page->publish();
        //     }
        // });

        // static::unpublished(function ($event) {
        //     if ($event->page_id != null) {
        //         $page = $event
        //             ->page()
        //             ->withNotPublished()
        //             ->withArchived()
        //             ->withTrashed()
        //             ->get()
        //             ->first();
        //         $page->unpublish();
        //     }
        // });
    }

    public function getIsOnlineAttribute()
    {
        if ($this->extras) {
            return Str::contains(Str::lower($this->extras->get('location', '')), 'online');
        }
        return false;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header');
    }

    public function isActive(): bool 
    {
        $now = Carbon::now()->toDateTimeString();
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

    /**
     * Returns all upcoming events that have a start date
     * which is greater than now.
     *
     * @return Builder
     */
    public function scopeUpcoming(Builder $query)
    {
        return $query
            ->where(function ($query) {
                $query->where('start_date', '>=', Carbon::now());
            });
    }

    public function scopeOnlyOnline(Builder $query)
    {
        return $query
            ->where('extras->attendance_mode', Event::ATTENDANCE_ONLINE);
    }

    public function scopeOnlineAndMixed(Builder $query)
    {
        return $query
            ->where(function ($query) {
                $query
                    ->where('extras->attendance_mode', Event::ATTENDANCE_ONLINE)
                    ->orWhere('extras->attendance_mode', Event::ATTENDANCE_MIXED);
            });
    }

    public function scopeOffline(Builder $query) 
    {
        return $query
            ->where(function ($query) {
                $query
                    ->where('extras->attendance_mode', Event::ATTENDANCE_ONLINE)
                    ->orWhere('extras->attendance_mode', null);
            });
    }

    public function scopeWithDaysDuration(Builder $builder)
    {
        $builder->when(empty($builder->getQuery()->columns), fn ($q) => $q->select('*'))
            ->selectRaw('datediff(end_date, start_date) as days_duration');
    }

    public function scopeWithMinutesDuration(Builder $builder)
    {
        $builder->when(empty($builder->getQuery()->columns), fn ($q) => $q->select('*'))
            ->selectRaw('TIMESTAMPDIFF(MINUTE, start_date, end_date) as minutes_duration');
    }

    public function scopeWithSecondsDuration(Builder $builder)
    {
        $builder->when(empty($builder->getQuery()->columns), fn ($q) => $q->select('*'))
            ->selectRaw('TIMESTAMPDIFF(MINUTE, start_date, end_date) as seconds_duration');
    }

    public function scopeOnlyLongTermEvents(Builder $query, ?int $duration_threshold = null)
    {
        if (! $duration_threshold) {
            $duration_threshold = config('mm-events.min_long_event_duration', 2 * 24 * 60 * 60);
        }

        $query->whereRaw('TIMESTAMPDIFF(SECOND, start_date, end_date) >= ?', [$duration_threshold]);
    }

    public function scopeWithoutLongTermEvents(Builder $builder, ?int $duration_threshold = null)
    {
        if (! $duration_threshold) {
            $duration_threshold = config('mm-events.min_long_event_duration', 2 * 24 * 60 * 60);
        }

        $builder
            ->where(function ($query) {
                $query
                    ->where('start_date', '!=', null)
                    ->whereNull('end_date');
            })
            ->orWhereRaw('TIMESTAMPDIFF(SECOND, start_date, end_date) < ?', [$duration_threshold]);
    }

    public function scopeFilter($query, array $filters): void
    {
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        parent::scopeFilter($query, $filters);

        $query->when($filters['category'] ?? null, function ($query, $category) use ($locale, $fallback) {
            $query
                ->where("category->${locale}", 'like', '%' . $category . '%')
                ->orWhere("category->${fallback}", 'like', '%' . $category . '%');
        });
    }
}
