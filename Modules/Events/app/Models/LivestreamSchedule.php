<?php

namespace Modules\Events\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Events\Database\Factories\LivestreamScheduleFactory;

class LivestreamSchedule extends Model
{
    use HasFactory;

    protected $guarded = ['*', 'id'];

    public function livestreamItems(): HasMany
    {
        return $this->hasMany(LivestreamItem::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'livestream_items')->using(LivestreamItem::class);
    }

    protected static function newFactory(): LivestreamScheduleFactory
    {
        return LivestreamScheduleFactory::new();
    }
}
