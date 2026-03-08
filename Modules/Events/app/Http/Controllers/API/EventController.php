<?php

namespace Modules\Events\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Events\Data\Event as EventData;
use Modules\Events\Models\Event;
use Spatie\LaravelData\PaginatedDataCollection;

class EventController extends Controller
{
    public function index(): PaginatedDataCollection
    {
        $events = Event::query()
            ->chronological()
            ->with(['media', 'place', 'organisation.media'])
            ->future()
            ->jsonPaginate();

        return EventData::collect(
            $events->through(fn (Event $event) => EventData::fromModel($event)),
            PaginatedDataCollection::class,
        );
    }

    public function show(int $id): EventData
    {
        $event = Cache::remember('api.events.show.'.$id, 2 * 60, function () use ($id) {
            return Event::query()->with(['media', 'page', 'place', 'organisation.media'])->findOrFail($id);
        });

        return EventData::fromModel($event);
    }
}
