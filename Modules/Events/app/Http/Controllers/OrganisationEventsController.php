<?php

namespace Modules\Events\Http\Controllers;

use Modules\Events\Models\Event;
use Modules\Management\Models\Organisation;

class OrganisationEventsController
{
    public function index(Organisation $organisation)
    {
        $events = Event::query()->get();

        return inertia('organisations/events/index-events', [
            'organisation' => \Modules\Management\Data\Organisation::from($organisation),
        ]);
    }
}
