<?php

use Modules\Events\Models\Event;
use Modules\Events\Models\Ticket;
use Modules\Events\Models\TicketAssignment;

it('can be created', function () {

    $ticket = Ticket::factory()->create();
    $event = Event::factory()->create();

    $assignment = TicketAssignment::create([
        'ticket_id' => $ticket->id,
        'event_id' => $event->id,
    ]);

    expect($assignment->ticket_id)->toBe($ticket->id);
    expect($assignment->event_id)->toBe($event->id);

});

test('event can have assigned tickets', function () {

    $ticket = Ticket::factory()->create([
        'published_at' => now(),
    ]);
    $event = Event::factory()->published()->create([
        'published_at' => now(),
    ]);

    $event = Event::find($event->id);

    $assignment = TicketAssignment::create([
        'ticket_id' => $ticket->id,
        'event_id' => $event->id,
    ]);

    expect($event->ticketAssignments->first()->id)->toBe($ticket->id);
    expect($event->ticketAssignments)->toHaveCount(1);

});
