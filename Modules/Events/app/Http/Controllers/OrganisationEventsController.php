<?php

namespace Modules\Events\Http\Controllers;

use Modules\Events\Data\Event as EventResource;
use Modules\Events\Models\Event;
use Modules\Management\Data\Organisation as OrganisationData;
use Modules\Management\Models\Organisation;

class OrganisationEventsController
{
    public function index(Organisation $organisation)
    {
        $events = Event::query()
            ->where('organisation_id', $organisation->id)
            ->where('parent_event_id', null)
            ->orderBy('start_date', 'asc')
            ->paginate(10)
            ->withQueryString()
            ->through(fn (Event $event) => EventResource::from($event));

        return inertia('organisations/events/index-events', [
            'organisation' => OrganisationData::from($organisation),
            'events' => $events,
        ]);
    }
}
