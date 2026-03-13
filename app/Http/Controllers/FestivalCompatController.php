<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Services\FestivalCompatSerializer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Modules\Events\Models\Event;
use Modules\Events\Models\LivestreamSchedule;
use Modules\Locations\Models\Location;
use Modules\News\Http\Resources\Feed as FeedResource;
use Modules\News\Http\Resources\PostCollection;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;

class FestivalCompatController extends Controller
{
    public function __construct(
        private readonly FestivalCompatSerializer $serializer
    ) {}

    public function eventsIndex(): JsonResponse
    {
        $events = $this->festivalEventsQuery()
            ->with(['place', 'media'])
            ->paginate(config('festival.pagination.events'));

        return $this->paginatedResponse(
            $events,
            fn (Event $event) => $this->serializer->event($event)
        );
    }

    public function eventsShow(int $id): JsonResponse
    {
        $event = $this->festivalEventsQuery()
            ->with(['page.blocks.children', 'place', 'media'])
            ->findOrFail($id);

        return response()->json([
            'data' => $this->serializer->event($event),
        ]);
    }

    public function festivalContent(): JsonResponse
    {
        $events = $this->festivalEventsQuery()
            ->with(['page.blocks.children', 'place', 'media'])
            ->paginate(config('festival.pagination.content'));

        return $this->paginatedResponse(
            $events,
            fn (Event $event) => $this->serializer->event($event)
        );
    }

    public function festivalEventShow(int $id): JsonResponse
    {
        $event = $this->festivalEventsQuery()
            ->with(['page.blocks.children', 'place', 'media'])
            ->findOrFail($id);

        $eventPayload = $this->serializer->event($event);
        unset($eventPayload['page'], $eventPayload['place']);

        return response()->json([
            'data' => [
                'header' => $this->serializer->headerForEvent($event),
                'event' => $eventPayload,
                'page' => $event->page ? $this->serializer->page($event->page) : null,
                'place' => $event->place ? $this->serializer->place($event->place) : null,
            ],
        ]);
    }

    public function locationsIndex(): JsonResponse
    {
        $locations = $this->festivalLocationsQuery()
            ->with([
                'events' => fn (Builder $query) => $this->applyCurrentFestivalConstraint($query)
                    ->with('media')
                    ->chronological(),
            ])
            ->get()
            ->map(fn (Location $location) => $this->serializer->place($location))
            ->values();

        return response()->json([
            'data' => $locations,
        ]);
    }

    public function locationsShow(int $id): JsonResponse
    {
        $location = $this->festivalLocationsQuery()
            ->whereKey($id)
            ->with([
                'events' => fn (Builder $query) => $this->applyCurrentFestivalConstraint($query)
                    ->with('media')
                    ->chronological(),
            ])
            ->firstOrFail();

        return response()->json([
            'data' => $this->serializer->place($location),
        ]);
    }

    public function mapVenuesIndex(): JsonResponse
    {
        $locations = Location::query()
            ->whereHas('events', fn (Builder $query) => $this->applyCurrentFestivalConstraint($query)->activeOrUpcoming())
            ->orderBy('id')
            ->get()
            ->map(fn (Location $location) => $this->serializer->place($location))
            ->values();

        return response()->json([
            'data' => $locations,
        ]);
    }

    public function mapVenuesShow(int $id): JsonResponse
    {
        $location = Location::query()
            ->whereKey($id)
            ->whereHas('events', fn (Builder $query) => $this->applyCurrentFestivalConstraint($query)->activeOrUpcoming())
            ->with([
                'events' => fn (Builder $query) => $this->applyCurrentFestivalConstraint($query)
                    ->activeOrUpcoming()
                    ->with('media')
                    ->chronological(),
            ])
            ->firstOrFail();

        return response()->json([
            'data' => $this->serializer->place($location),
        ]);
    }

    public function pageShow(int $id): JsonResponse
    {
        $page = Page::query()
            ->with(['blocks.children', 'media'])
            ->findOrFail($id);

        return response()->json([
            'data' => $page,
        ]);
    }

    public function feedShow(int $id): FeedResource
    {
        $resolvedFeedId = $this->resolveFeedId($id);
        $sizeParameter = config('json-api-paginate.size_parameter');
        $paginationParameter = config('json-api-paginate.pagination_parameter');
        $defaultSize = config('festival.pagination.feed_posts');
        $size = (int) request()->input($paginationParameter.'.'.$sizeParameter, $defaultSize);

        return new FeedResource(
            Feed::with([
                'posts' => fn ($query) => $query
                    ->with(['media'])
                    ->chronological()
                    ->jsonPaginate($size),
            ])->findOrFail($resolvedFeedId)
        );
    }

    public function feedPostsIndex(int $id): PostCollection
    {
        $resolvedFeedId = $this->resolveFeedId($id);

        return new PostCollection(
            Feed::findOrFail($resolvedFeedId)
                ->posts()
                ->with(['media'])
                ->chronological()
                ->jsonPaginate(config('festival.pagination.feed_posts'))
        );
    }

    public function postShow(int $id): JsonResponse
    {
        $post = Post::query()
            ->whereKey($id)
            ->with(['media'])
            ->firstOrFail();

        if (! $post->isPublished()) {
            return response()->json(['data' => null], 404);
        }

        return response()->json([
            'data' => $post,
        ]);
    }

    public function streamIndex(): JsonResponse
    {
        $schedule = LivestreamSchedule::query()
            ->with([
                'events' => fn (Builder $query) => $this->applyCurrentFestivalConstraint($query)
                    ->with(['place', 'media'])
                    ->chronological(),
            ])
            ->where(function (Builder $query) {
                $query
                    ->where('end_date', '>=', now())
                    ->orWhere('start_date', '>=', now());
            })
            ->orderBy('start_date')
            ->first();

        $configuredStartDate = config('festival.stream.start_date');
        $startDate = $schedule?->start_date;

        if ($startDate === null && is_string($configuredStartDate) && $configuredStartDate !== '') {
            $startDate = Carbon::parse($configuredStartDate);
        }

        return response()->json([
            'start_date' => $startDate,
            'url' => config('festival.stream.url'),
            'failure_title' => config('festival.stream.failure_title'),
            'failure_description' => config('festival.stream.failure_description'),
            'events' => $schedule?->events
                ? $schedule->events->map(fn (Event $event) => $this->serializer->event($event))->values()->all()
                : [],
        ]);
    }

    private function festivalEventsQuery(): Builder
    {
        return $this->applyCurrentFestivalConstraint(Event::query())
            ->chronological();
    }

    private function festivalLocationsQuery(): Builder
    {
        return Location::query()
            ->whereHas('events', fn (Builder $query) => $this->applyCurrentFestivalConstraint($query))
            ->orderBy('id');
    }

    private function applyCurrentFestivalConstraint(Builder $query): Builder
    {
        return $query
            ->where('extras->collection', $this->currentCollection())
            ->whereNotNull('extras->external_id');
    }

    private function currentCollection(): string
    {
        return config('festival.current_collection');
    }

    private function resolveFeedId(int $id): int
    {
        return (int) config("festival.feed_aliases.$id", $id);
    }

    private function paginatedResponse(LengthAwarePaginator $paginator, callable $map): JsonResponse
    {
        return response()->json([
            'data' => $paginator->getCollection()->map($map)->values()->all(),
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'from' => $paginator->firstItem(),
                'last_page' => $paginator->lastPage(),
                'links' => method_exists($paginator, 'linkCollection') ? $paginator->linkCollection()->toArray() : [],
                'path' => $paginator->path(),
                'per_page' => $paginator->perPage(),
                'to' => $paginator->lastItem(),
                'total' => $paginator->total(),
            ],
        ]);
    }
}
