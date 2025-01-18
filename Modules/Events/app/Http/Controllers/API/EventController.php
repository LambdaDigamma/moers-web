<?php

namespace Modules\Events\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Modules\Events\Models\Event;
use PHPUnit\Event\EventCollection;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): EventCollection
    {
        $events = Event::query()
            // ->with('place')
            ->chronological()
            ->future()
            ->jsonPaginate();

        return new EventCollection($events);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        return Event::query()
            // ->with(['page'])
            ->findOrFail($id);
    }

    public function overview(): JsonResponse
    {
        $longTermEvents = Cache::remember('api-events-overview-long-term', 5 * 60, function () {
            return Event::query()
                ->onlyLongTermEvents()
                ->where(function ($query) {
                    $query
                        ->where(function ($query) {
                            $query->active();
                        });
                })
                ->chronological()
                ->get();
        });

        $activeEvents = Cache::remember('api-events-overview-active', 5 * 60, function () {
            return Event::query()
                ->withoutLongTermEvents()
                ->where(function ($query) {
                    $query
                        ->where(function ($query) {
                            $query->active();
                        })
                        ->orWhere(function ($query) {
                            $query->today();
                        });
                })
                ->chronological()
                ->get();
        });

        return new JsonResponse([
            'data' => [
                'today_events' => $activeEvents,
                'current_long_term_events' => $longTermEvents,
            ],
        ]);
    }
}
