<?php

namespace Modules\Events\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Events\Data\Event as EventResource;
use Modules\Events\Http\Requests\StoreEventRequest;
use Modules\Events\Http\Requests\UpdateGeneralEvent;
use Modules\Events\Models\Event;

class EventController extends Controller
{
    public function index(Request $request): Response
    {
        $requestedType = $request->string('type')->toString();

        $filters = [
            'search' => trim($request->string('search')->toString()),
            'type' => $request->has('type') ? $requestedType : 'upcoming',
            'collection' => $request->string('collection')->toString(),
            'category' => $request->string('category')->toString(),
            'organisation' => $request->string('organisation')->toString(),
            'location' => $request->string('location')->toString(),
        ];

        $events = Event::query()
            ->with(['media', 'place', 'organisation.media'])
            ->filter($filters)
            ->chronological()
            ->paginate(12)
            ->withQueryString()
            ->through(fn (Event $event) => EventResource::fromModel($event));

        return inertia('events/index', [
            'events' => Inertia::scroll($events),
            'filters' => $filters,
            'availableFilters' => [
                'types' => [
                    ['value' => 'upcoming', 'label' => 'Bevorstehend'],
                    ['value' => 'past', 'label' => 'Vergangen'],
                    ['value' => 'all', 'label' => 'Alle Termine'],
                ],
                'collections' => Event::query()
                    ->whereNotNull('extras->collection')
                    ->orderBy('extras->collection')
                    ->pluck('extras->collection')
                    ->filter()
                    ->unique()
                    ->values()
                    ->all(),
                'categories' => Event::query()
                    ->whereNotNull('category')
                    ->get()
                    ->map(fn (Event $event) => $event->category)
                    ->filter()
                    ->unique()
                    ->sort()
                    ->values()
                    ->all(),
                'organisations' => Event::query()
                    ->with('organisation')
                    ->whereNotNull('organisation_id')
                    ->get()
                    ->map(fn (Event $event) => $event->organisation)
                    ->filter()
                    ->unique('id')
                    ->sortBy('name')
                    ->values()
                    ->map(fn ($organisation) => [
                        'value' => (string) $organisation->id,
                        'label' => $organisation->name,
                    ])
                    ->all(),
                'locations' => Event::query()
                    ->with('place')
                    ->whereNotNull('place_id')
                    ->get()
                    ->map(fn (Event $event) => $event->place)
                    ->filter()
                    ->unique('id')
                    ->sortBy('name')
                    ->values()
                    ->map(fn ($location) => [
                        'value' => (string) $location->id,
                        'label' => $location->name,
                    ])
                    ->all(),
            ],
        ]);
    }

    public function show(
        Request $request,
        Event $event
    ): Response {
        $event->loadMissing(['media', 'place', 'organisation.media']);

        $backUrl = $request->string('back')->toString();

        if (! str_starts_with($backUrl, '/')) {
            $backUrl = route('events.index');
        }

        return inertia('events/show-event', [
            'event' => EventResource::fromModel($event),
            'backUrl' => $backUrl,
        ]);
    }

    public function edit(
        Event $event
    ) {
        return inertia('events/edit-event-general', [
            'event' => EventResource::fromModel($event),
        ]);
    }

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
