<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\AdvEvent
 *
 * @property int                                                                                                $id
 * @property string                                                                                             $name
 * @property string|null                                                                                        $start_date
 * @property string|null                                                                                        $end_date
 * @property string|null                                                                                        $description
 * @property string|null                                                                                        $url
 * @property string|null                                                                                        $image_path
 * @property string|null                 $category
 * @property int|null                    $organisation_id
 * @property int|null                    $entry_id
 * @property int                         $is_published
 * @property array|null                  $extras
 * @property Carbon|null                 $deleted_at
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @property-read \App\Models\Entry|null $entry
 * @property-read Organisation|null      $organisation
 * @method static bool|null forceDelete()
 * @method static Builder|AdvEvent newModelQuery()
 * @method static Builder|AdvEvent newQuery()
 * @method static \Illuminate\Database\Query\Builder|AdvEvent onlyTrashed()
 * @method static Builder|AdvEvent query()
 * @method static bool|null restore()
 * @method static Builder|AdvEvent whereCategory($value)
 * @method static Builder|AdvEvent whereCreatedAt($value)
 * @method static Builder|AdvEvent whereDeletedAt($value)
 * @method static Builder|AdvEvent whereDescription($value)
 * @method static Builder|AdvEvent whereEndDate($value)
 * @method static Builder|AdvEvent whereEntryId($value)
 * @method static Builder|AdvEvent whereExtras($value)
 * @method static Builder|AdvEvent whereId($value)
 * @method static Builder|AdvEvent whereImagePath($value)
 * @method static Builder|AdvEvent whereIsPublished($value)
 * @method static Builder|AdvEvent whereName($value)
 * @method static Builder|AdvEvent whereOrganisationId($value)
 * @method static Builder|AdvEvent whereStartDate($value)
 * @method static Builder|AdvEvent whereUpdatedAt($value)
 * @method static Builder|AdvEvent whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|AdvEvent withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AdvEvent withoutTrashed()
 * @mixin Eloquent
 * @property int|null                                                                                           $page_id
 * @property string|null                                                                                        $scheduled_at
 * @property-read mixed                                                                                         $header_url
 * @property-read mixed                                                                                         $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null                                                                                      $media_count
 * @property-read \App\Models\Page|null                                                                         $page
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent chronological()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent future()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent nextDays()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent today()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvEvent upcomingToday()
 */
class AdvEvent extends Model implements HasMedia
{
    use SoftDeletes;
    use HasTranslations;
    use InteractsWithMedia;

    protected $table = 'adv_events';

    protected $fillable = ['name', 'start_date', 'end_date',
        'description', 'url', 'image_path', 'category',
        'organisation_id', 'entry_id', 'extras', 'is_published', 'scheduled_at'];

    protected $casts = [
        'extras' => 'array'
    ];

    protected $appends = ['header_url'];

    public $translatable = ['name', 'description', 'category'];

    public function getHeaderUrlAttribute()
    {
        if (!is_null($this->getFirstMedia('header'))) {
            return $this->getFirstMedia('header')->getUrl();
        }
    }

    public function getImagePathAttribute()
    {
        if (!is_null($this->getFirstMedia('header'))) {
            return $this->getFirstMedia('header')->getUrl();
        }
    }

    public function organisation()
    {
        return $this->belongsTo('App\Models\Organisation');
    }

    public function entry()
    {
        return $this->belongsTo('App\Models\Entry');
    }

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

    public function toArray()
    {
        $attributes = parent::toArray();

        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }

        return $attributes;
    }

    public function scopePublished($query)
    {
        return $query
            ->where('scheduled_at', '<=', Carbon::now()->toDateTimeString())
            ->orWhere('scheduled_at', '=', null);
    }

    public function scopeActive($query)
    {
        $now = Carbon::now()->toDateTimeString();
        $deadline = Carbon::now()->addMinutes(-30)->toDateTimeString();

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

    public function scopeToday(Builder $query)
    {
        $now = Carbon::now()->toDateTimeString();
        $today = Carbon::now()->toDateString();
        return $query
            ->whereDate('start_date', '=', $today)
            ->orWhereDate('end_date', '=', $today)
            ->orWhere(function (Builder $query) use ($now) {
                $query
                    ->where('end_date', '>=', $now)
                    ->where('start_date', '<=', $now);
            });
    }

    public function scopeUpcomingToday(Builder $query)
    {
        $now = Carbon::now()->toDateTimeString();
        return $query
            ->where('start_date', '>', $now)
            ->orWhere('start_date', '=', null);
    }

    public function scopeNextDays(Builder $query)
    {
        $today = Carbon::now()->toDateString();
        return $query
            ->whereDate('start_date', '>', $today)
            ->orWhere('start_date', '=', null);
    }

    public function scopeChronological(Builder $query)
    {
        return $query->orderByRaw('-start_date DESC');
    }

    public function scopeFuture(Builder $query)
    {
        return $query->whereDate('start_date', '>=', now()->toDateString())
            ->orWhere('start_date', '=', null);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
