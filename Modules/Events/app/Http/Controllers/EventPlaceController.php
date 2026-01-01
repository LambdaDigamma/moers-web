<?php

namespace Modules\Events\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Modules\Events\Http\Requests\UpdatePlaceEvent;
use Modules\Events\Models\Event;

class EventPlaceController extends Controller
{
    public function edit(Event $event): Response
    {
        return inertia('events/venue/edit', [
            'event' => $event,
        ]);
    }

    public function update(UpdatePlaceEvent $request, Event $event): JsonResponse|RedirectResponse
    {
        $event->place_id = $request->place_id;
        $event->save();

        return $request->wantsJson()
                ? new JsonResponse('', 200)
                : redirect()->back()->with('success', 'Der neue Spielort wurde gespeichert.');
    }
}
