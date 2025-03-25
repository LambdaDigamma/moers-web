<?php

namespace Modules\Events\Http\Controllers\API;

use Modules\Events\Http\Controllers\Controller;
use Modules\Events\Models\Event;
use Modules\Management\Models\Organisation;
use Spatie\LaravelData\PaginatedDataCollection;

class OrganisationEventsController extends Controller
{
    public function index(Organisation $organisation)
    {
        $events = Event::query()
            ->where('organisation_id', $organisation->id)
//            ->with(['venues'])
            ->chronological()
            ->paginate(20);

        //        return PaginatedDataCollection::

    }
}
