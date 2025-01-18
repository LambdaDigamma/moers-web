<?php

namespace Modules\Events\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Events\Database\Factories\LivestreamItemFactory;

class LivestreamItem extends Pivot
{
    use HasFactory;

    protected $table = 'livestream_items';

    protected $guarded = ['*', 'id'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    protected static function newFactory(): LivestreamItemFactory
    {
        return LivestreamItemFactory::new();
    }
}
