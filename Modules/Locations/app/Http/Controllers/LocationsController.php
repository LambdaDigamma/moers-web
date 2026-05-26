<?php

namespace Modules\Locations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Response;
use Modules\Events\Models\Event;
use Modules\Locations\Http\Requests\StoreLocationRequest;
use Modules\Locations\Http\Requests\UpdateLocationRequest;
use Modules\Locations\Models\Location;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class LocationsController extends Controller
{
    public function create(Request $request): Response
    {
        return inertia('locations/create-location', [
            'backUrl' => $this->backUrl($request),
            'returnToEvent' => $this->eventContext($request),
        ]);
    }

    public function store(StoreLocationRequest $request): RedirectResponse
    {
        $location = DB::transaction(function () use ($request): Location {
            $location = new Location;

            $this->fillLocation($location, $request->validated());
            $location->save();
            $location->load('media');

            $this->syncHeaderMedia($location, $request);

            return $location;
        });

        return $this->redirectAfterSave($request, $location, 'Der Ort wurde erstellt.');
    }

    public function edit(Request $request, Location $location): Response
    {
        $location->load('media');

        return inertia('locations/edit-location', [
            'location' => $this->serializedLocation($location),
            'backUrl' => $this->backUrl($request),
            'returnToEvent' => $this->eventContext($request),
        ]);
    }

    public function update(UpdateLocationRequest $request, Location $location): RedirectResponse
    {
        DB::transaction(function () use ($request, $location): void {
            $this->fillLocation($location, $request->validated());
            $location->save();
            $location->load('media');

            $this->syncHeaderMedia($location, $request);
        });

        return $this->redirectAfterSave($request, $location, 'Der Ort wurde gespeichert.');
    }

    public function destroy(Request $request, Location $location): RedirectResponse
    {
        if ($location->events()->withTrashed()->withNotPublished()->withArchived()->exists()) {
            throw ValidationException::withMessages([
                'location' => 'Dieser Ort kann nicht gelöscht werden, solange noch Veranstaltungen damit verknüpft sind.',
            ]);
        }

        $location->delete();

        if ($event = $this->eventContext($request)) {
            return redirect()
                ->route('events.venue.edit', $event['id'])
                ->with('success', 'Der Ort wurde gelöscht.');
        }

        return redirect()->route('dashboard')->with('success', 'Der Ort wurde gelöscht.');
    }

    private function fillLocation(Location $location, array $validated): void
    {
        $locale = app()->getLocale();

        $location->setTranslation('name', $locale, $validated['name']);
        $location->setTranslation('tags', $locale, $validated['tags'] ?? '');

        $location->lat = (float) $validated['lat'];
        $location->lng = (float) $validated['lng'];
        $location->street_name = $validated['street_name'] ?? null;
        $location->street_number = $validated['street_number'] ?? null;
        $location->address_addition = $validated['address_addition'] ?? null;
        $location->postalcode = $validated['postalcode'] ?? null;
        $location->postal_town = $validated['postal_town'] ?? null;
        $location->country_code = $validated['country_code'] ?? 'DE';
        $location->url = $validated['url'] ?? null;
        $location->phone = $validated['phone'] ?? null;
    }

    private function syncHeaderMedia(Location $location, Request $request): void
    {
        if (! $request->boolean('sync_media') && ! $request->has('media')) {
            return;
        }

        $locale = app()->getLocale();
        $submittedMedia = collect($request->input('media', []));
        $existingMedia = $location->getMedia('header')->keyBy('id');
        $orderedMedia = new Collection;
        $keptMediaIds = [];

        foreach ($submittedMedia as $index => $mediaItem) {
            $existingMediaId = isset($mediaItem['id']) ? (int) $mediaItem['id'] : null;

            if ($existingMediaId !== null) {
                if (! $existingMedia->has($existingMediaId)) {
                    throw ValidationException::withMessages([
                        'media' => 'Ein ausgewähltes Bild konnte diesem Ort nicht zugeordnet werden.',
                    ]);
                }
            }
        }

        foreach ($submittedMedia as $index => $mediaItem) {
            $existingMediaId = isset($mediaItem['id']) ? (int) $mediaItem['id'] : null;

            if ($existingMediaId !== null) {
                /** @var Media $media */
                $media = $existingMedia->get($existingMediaId);

                $this->syncMediaTranslations($media, $locale, $mediaItem);
                $orderedMedia->push($media);
                $keptMediaIds[] = $media->id;

                continue;
            }

            if (! $request->hasFile("media.$index.file")) {
                continue;
            }

            /** @var BaseMedia $uploadedMedia */
            $uploadedMedia = $location
                ->addMedia($request->file("media.$index.file"))
                ->toMediaCollection('header');

            /** @var Media $resolvedMedia */
            $resolvedMedia = Media::query()->findOrFail($uploadedMedia->id);
            $this->syncMediaTranslations($resolvedMedia, $locale, $mediaItem);

            $orderedMedia->push($resolvedMedia);
            $keptMediaIds[] = $resolvedMedia->id;
        }

        $location->getMedia('header')
            ->reject(fn (BaseMedia $media) => in_array($media->id, $keptMediaIds, true))
            ->each(fn (BaseMedia $media) => $media->delete());

        $orderedMedia->each(function (Media $media, int $index): void {
            $media->order_column = $index + 1;
            $media->save();
        });
    }

    private function syncMediaTranslations(Media $media, string $locale, array $attributes): void
    {
        $media->setTranslation('alt', $locale, (string) ($attributes['alt'] ?? ''));
        $media->setTranslation('caption', $locale, (string) ($attributes['caption'] ?? ''));
        $media->setTranslation('credits', $locale, (string) ($attributes['credits'] ?? ''));
        $media->save();
    }

    private function redirectAfterSave(Request $request, Location $location, string $message): RedirectResponse
    {
        if ($event = $this->eventContext($request)) {
            return redirect()
                ->to(route('events.venue.edit', $event['id']).'?location='.$location->id)
                ->with('success', $message);
        }

        return redirect()->route('locations.edit', $location)->with('success', $message);
    }

    private function serializedLocation(Location $location): array
    {
        $payload = $location->toArray();
        $payload['address'] = collect([
            trim(implode(' ', array_filter([$location->street_name, $location->street_number]))),
            trim(implode(' ', array_filter([$location->postalcode, $location->postal_town]))),
        ])->filter()->implode(', ');

        return $payload;
    }

    private function backUrl(Request $request): string
    {
        if ($event = $this->eventContext($request)) {
            return route('events.venue.edit', $event['id']);
        }

        $back = $request->string('back')->toString();

        if (Str::startsWith($back, '/') && ! Str::startsWith($back, '//')) {
            return $back;
        }

        return route('dashboard');
    }

    private function eventContext(Request $request): ?array
    {
        $eventId = $request->integer('event') ?: $request->integer('return_to_event');

        if ($eventId === 0) {
            return null;
        }

        $event = Event::query()
            ->select(['id', 'name'])
            ->withTrashed()
            ->withNotPublished()
            ->withArchived()
            ->find($eventId);

        if ($event === null) {
            return null;
        }

        return [
            'id' => $event->id,
            'name' => $event->name,
        ];
    }
}
