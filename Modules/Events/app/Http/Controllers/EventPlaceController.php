<?php

namespace Modules\Events\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Modules\Events\Data\Event as EventResource;
use Modules\Events\Http\Requests\UpdatePlaceEvent;
use Modules\Events\Models\Event;
use Modules\Locations\Models\Location;

class EventPlaceController extends Controller
{
    public function edit(Request $request, Event $event): Response
    {
        $selectedLocationId = $request->integer('location');

        if ($selectedLocationId === 0) {
            $selectedLocationId = $event->place_id;
        }

        $selectedLocation = $selectedLocationId
            ? Location::query()->with('media')->find($selectedLocationId)
            : null;

        $locations = Location::query()
            ->with('media')
            ->get()
            ->sortBy(fn (Location $location) => mb_strtolower($location->name))
            ->values()
            ->map(fn (Location $location) => [
                'id' => $location->id,
                'name' => $location->name,
                'address' => collect([
                    trim(implode(' ', array_filter([$location->street_name, $location->street_number]))),
                    trim(implode(' ', array_filter([$location->postalcode, $location->postal_town]))),
                ])->filter()->implode(', '),
                'url' => $location->url,
                'phone' => $location->phone,
                'tags' => $location->tags,
                'media_collections' => $location->toArray()['media_collections'] ?? [],
            ])
            ->all();

        return inertia('events/venue/edit', [
            'event' => EventResource::fromModel($event->loadMissing('place')),
            'availableLocations' => $locations,
            'selectedLocationId' => $selectedLocation?->id,
            'selectedLocation' => $selectedLocation
                ? [
                    ...$selectedLocation->toArray(),
                    'address' => collect([
                        trim(implode(' ', array_filter([$selectedLocation->street_name, $selectedLocation->street_number]))),
                        trim(implode(' ', array_filter([$selectedLocation->postalcode, $selectedLocation->postal_town]))),
                    ])->filter()->implode(', '),
                ]
                : null,
            'canManageLocations' => $request->user()?->isAdmin() ?? false,
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
