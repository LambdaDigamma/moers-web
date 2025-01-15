<?php

namespace Modules\Events\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Modules\Events\Http\Requests\StoreEventRequest;
use Modules\Events\Http\Requests\UpdateGeneralEvent;
use Modules\Events\Models\Event;

class EventController extends Controller
{
    public function store(StoreEventRequest $request): JsonResponse|RedirectResponse
    {
        $event = Event::create($request->validated());

        return $request->wantsJson()
                ? new JsonResponse($event, 302)
                : back()->with('success', 'Die Veranstaltung wurde erstellt.')->with('data', ['id' => $event->id]);
    }

    public function update(UpdateGeneralEvent $request, Event $event): JsonResponse|RedirectResponse
    {
        $event->fill($request->except(['start_date', 'end_date']));
        $event->extras?->put('collection', $request->get(key: 'collection'));

        if ($request->start_date != null) {
            $event->start_date = Carbon::parse($request->start_date)
                ->timezone(config('app.timezone', 'UTC'))
                ->toDateTimeLocalString();
        } else {
            $event->start_date = null;
        }

        if ($request->end_date != null) {
            $event->end_date = Carbon::parse($request->end_date)
                ->timezone(config('app.timezone', 'UTC'))
                ->toDateTimeLocalString();
        } else {
            $event->end_date = null;
        }

        $event->save();

        return $request->wantsJson()
                ? new JsonResponse('', 200)
                : back()->with('success', 'Die Daten wurden gespeichert.');
    }
}
