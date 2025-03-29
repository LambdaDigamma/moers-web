<?php

namespace Modules\Events\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Events\Models\Event;
use Modules\Events\Resources\EventCollection;

class EventController extends Controller
{
    public function index(): EventCollection
    {
        $events = Event::query()
            // ->with('place')
            ->chronological()
            ->with(['place'])
            ->future()
            ->jsonPaginate();

        return new EventCollection($events);
    }
    
    public function show(int $id)
    {
        $event = Cache::remember('api.events.show.' . $id, 2 * 60, function () use ($id) {
            return Event::query()->with(['page', 'place'])->findOrFail($id);
        });

        return new EventCollection($event);
    }
}
