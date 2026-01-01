<?php

namespace Modules\Events\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TicketAssignment extends Pivot
{
    use HasTimestamps;

    protected $table = 'ticket_assignments';

    protected $guarded = ['*', 'id'];

    public $incrementing = true;

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
