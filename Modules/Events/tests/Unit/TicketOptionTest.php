<?php

use Modules\Events\Models\Ticket;
use Modules\Events\Models\TicketOption;

it('can be created', function () {

    $ticket = Ticket::factory()->published()->create([]);

    $ticketOption = TicketOption::create([
        'name' => 'Test',
        'price' => 10,
        'ticket_id' => $ticket->id,
    ]);

    expect($ticketOption->name)->toBe('Test');
    $ticketOption = TicketOption::factory()->for($ticket)->create();

    expect($ticketOption)->ticket->id->toBe($ticket->id);

});
