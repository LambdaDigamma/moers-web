<?php

namespace Modules\Multimedia\Models;

use App\Traits\SerializeTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Multimedia\Database\Factories\RadioBroadcastFactory;

class RadioBroadcast extends Model
{
    use HasFactory;
    use SerializeTranslations;

    public array $translatable = ['title', 'description'];

    public $fillable = ['title', 'description', 'starts_at', 'ends_at', 'uid', 'url', 'attach'];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    /**
     * Orders the query with a chronological start date.
     * Radio broadcasts without a start date go last.
     */
    public function scopeChronological(Builder $query): Builder
    {
        if (config('database.default') === 'pgsql') {
            return $query
                ->orderByRaw('published_at ASC NULLS LAST');
        } else {
            return $query
                ->orderByRaw('-published_at DESC');
        }
    }

    /**
     * Returns all events that have a start date greater than today.
     */
    public function scopeFuture(Builder $query): Builder
    {
        return $query
            ->whereDate('starts_at', '>=', now()->toDateString())
            ->orWhere('starts_at', '=', null);
    }

    public function scopeUpcoming(Builder $query): Builder
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

    protected static function newFactory(): RadioBroadcastFactory
    {
        return RadioBroadcastFactory::new();
    }

}
