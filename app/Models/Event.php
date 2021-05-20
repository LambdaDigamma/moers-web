<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Support\Carbon;
use LambdaDigamma\MMEvents\Models\Event as BaseEvent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends BaseEvent implements HasMedia
{
    use InteractsWithMedia;

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header');
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
}
