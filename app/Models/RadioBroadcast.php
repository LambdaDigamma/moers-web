<?php

namespace App\Models;

use App\Traits\SerializeTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class RadioBroadcast extends Model
{
    use HasFactory;
    use SerializeTranslations;
    
    public $translatable = ['title', 'description'];
    public $fillable = ['title', 'description', 'starts_at', 'ends_at', 'uid', 'url', 'attach'];
    public $dates = ['starts_at', 'ends_at'];

    /**
     * Orders the query with a chronological start date.
     * Radio broadcasts without a start date go last.
     *
     * @return Builder
     */
    public function scopeChronological(Builder $query)
    {
        return $query
            ->orderByRaw('-starts_at DESC');
    }

    /**
     * Returns all events that have a start date greater than today.
     *
     * @return Builder
     */
    public function scopeFuture(Builder $query)
    {
        return $query
            ->whereDate('starts_at', '>=', now()->toDateString())
            ->orWhere('starts_at', '=', null);
    }

    public function scopeUpcoming(Builder $query)
    {
        return $query
            ->where('starts_at', '>=', now()->toDateString())
            ->orWhere('starts_at', '=', null);
    }

    public function scopePast(Builder $query): Builder
    {
        return $query
            ->where('starts_at', '<=', now()->toDateString());
    }

}