<?php

use Modules\Events\Models\Ticket;
use Modules\Events\Models\TicketOption;

test('it can be created', function () {

    $ticket = Ticket::create([
        'name' => 'Festivalticket',
        'description' => null,
    ]);

    expect($ticket->id)->not->toBeNull();
    expect($ticket->name)->toBe('Festivalticket');

});

it('has ticket options', function () {

    $ticket = Ticket::create([
        'name' => 'Festivalticket',
        'description' => null,
    ]);

    $ticketOption = TicketOption::create([
        'name' => 'Standard',
        'price' => 40.0,
        'ticket_id' => $ticket->id,
    ]);

    $options = $ticket->ticketOptions()->get();

    expect($options[0]->id)->toBe($ticketOption->id);
    expect($options)->toHaveCount(1);

});
