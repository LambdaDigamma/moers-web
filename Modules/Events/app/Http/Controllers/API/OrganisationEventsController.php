<?php

namespace Modules\Events\Http\Controllers\API;

use Cache;
use Modules\Events\Http\Controllers\Controller;
use Modules\Events\Models\Event;
use Modules\Events\Resources\EventCollection;
use Modules\Management\Models\Organisation;
use Spatie\LaravelData\PaginatedDataCollection;

class OrganisationEventsController extends Controller
{
    public function index(Organisation $organisation)
    {
        $events = Cache::remember("api.organisations.{$organisation->id}.events.index", 2 * 60, function () use ($organisation) {
            return  Event::query()
                ->where('organisation_id', $organisation->id)
                ->where('parent_event_id', null)
                ->with(['place'])
                ->chronological()
                ->paginate(500);
        });

        return new EventCollection(resource: $events);
    }

    public function show(Organisation $organisation, Event $event)
    {
        return [
            'event' => $event
        ];
    }
}
