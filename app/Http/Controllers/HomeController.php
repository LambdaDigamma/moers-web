<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowHomePageRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Inertia\Response;
use Modules\Events\Models\Event;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;
use Modules\Parking\Models\ParkingArea;
use Modules\Waste\Models\RubbishStreet;

class HomeController extends Controller
{
    public function __invoke(ShowHomePageRequest $request): Response
    {
        $today = Carbon::today();
        $eventDay = $request->validated('event_day');

        $upcomingEvents = fn () => Event::query()
            ->with('place')
            ->whereNotNull('start_date')
            ->where('start_date', '>=', $today)
            ->when($eventDay, fn (Builder $query, string $day) => $query->whereBetween('start_date', [
                Carbon::parse($day)->startOfDay(),
                Carbon::parse($day)->endOfDay(),
            ]))
            ->orderBy('start_date')
            ->limit(6)
            ->get()
            ->map(fn (Event $event) => [
                'id' => $event->id,
                'name' => $event->name,
                'start_date' => $event->start_date?->toIso8601String(),
                'scheduleDisplay' => $event->schedule_display,
                'showsDateComponent' => $event->shows_date_component,
                'showsTimeComponent' => $event->shows_time_component,
                'location' => $event->place?->name,
                'category' => $event->category ?: null,
            ])
            ->all();

        $latestNews = fn () => Post::query()
            ->with(['feeds', 'media'])
            ->orderByDesc('published_at')
            ->limit(5)
            ->get()
            ->map(fn (Post $post) => [
                'id' => $post->id,
                'title' => $post->title,
                'summary' => $post->summary,
                'published_at' => $post->published_at?->toIso8601String(),
                'external_href' => $post->external_href,
                'source_name' => $post->feeds->map(fn (Feed $feed) => $feed->name)->filter()->first(),
                'header_image_url' => $post->getFirstMediaUrl('header') ?: null,
            ])
            ->all();

        $parkingAreas = fn () => ParkingArea::query()
            ->orderByOpeningState()
            ->limit(4)
            ->get()
            ->map(fn (ParkingArea $area) => [
                'id' => $area->id,
                'name' => $area->name,
                'slug' => $area->slug,
                'capacity' => $area->capacity,
                'occupied' => $area->occupied_sites,
                'state' => $area->current_opening_state,
                'updated_at' => $area->updated_at?->toIso8601String(),
            ])
            ->all();

        return inertia('home', [
            'stats' => function () use ($today): array {
                $openParkingAreas = ParkingArea::query()->open()->get();

                return [
                    'upcoming_events' => Event::query()
                        ->whereNotNull('start_date')
                        ->where('start_date', '>=', $today)
                        ->count(),
                    'events_today_and_tomorrow' => Event::query()
                        ->whereBetween('start_date', [$today, $today->copy()->addDay()->endOfDay()])
                        ->count(),
                    'news_posts' => Post::query()->count(),
                    'rubbish_streets' => RubbishStreet::query()->current()->count(),
                    'parking_spaces' => (int) ParkingArea::query()->sum('capacity'),
                    'free_parking_spaces' => $openParkingAreas->sum(fn (ParkingArea $area): int => max(0, $area->freeSites())),
                    'open_parking_areas' => $openParkingAreas->count(),
                ];
            },
            'upcomingEvents' => $upcomingEvents,
            'eventDayFilters' => fn (): array => $this->eventDayFilters(today: $today, eventDay: $eventDay),
            'selectedEventDay' => $eventDay ?? 'all',
            'latestNews' => $latestNews,
            'parkingAreas' => $parkingAreas,
            'mobileApps' => [
                'ios_url' => route('apps.ios'),
                'android_url' => route('apps.android'),
            ],
        ]);
    }

    /**
     * @return array<int, array{key: string, label: string}>
     */
    private function eventDayFilters(Carbon $today, ?string $eventDay): array
    {
        $tomorrow = $today->copy()->addDay();
        $laterDays = Event::query()
            ->where('start_date', '>=', $today->copy()->addDays(2))
            ->selectRaw('DATE(start_date) as event_day')
            ->distinct()
            ->orderBy('event_day')
            ->limit(3)
            ->pluck('event_day')
            ->all();

        $filters = [
            ['key' => 'all', 'label' => 'Alle'],
            ['key' => $today->toDateString(), 'label' => 'Heute'],
            ['key' => $tomorrow->toDateString(), 'label' => 'Morgen'],
            ...array_map(fn (string $day): array => [
                'key' => $day,
                'label' => Carbon::parse($day)->locale('de')->isoFormat('dd D.'),
            ], $laterDays),
        ];

        if ($eventDay !== null && ! in_array($eventDay, array_column($filters, 'key'), true)) {
            $filters[] = [
                'key' => $eventDay,
                'label' => Carbon::parse($eventDay)->locale('de')->isoFormat('dd D.'),
            ];
        }

        return $filters;
    }
}
