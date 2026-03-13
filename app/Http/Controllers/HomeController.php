<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Inertia\Response;
use Modules\Events\Models\Event;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;
use Modules\Parking\Models\ParkingArea;
use Modules\Waste\Models\RubbishStreet;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $upcomingEvents = Event::query()
            ->with('place')
            ->whereNotNull('start_date')
            ->where('start_date', '>=', Carbon::now()->startOfDay())
            ->orderBy('start_date')
            ->limit(4)
            ->get()
            ->map(fn (Event $event) => [
                'id' => $event->id,
                'name' => $event->name,
                'start_date' => $event->start_date?->toIso8601String(),
                'scheduleDisplay' => $event->schedule_display,
                'showsDateComponent' => $event->shows_date_component,
                'showsTimeComponent' => $event->shows_time_component,
                'location' => $event->place?->name,
            ])
            ->all();

        $latestNews = Post::query()
            ->with(['feeds', 'media'])
            ->orderByDesc('published_at')
            ->limit(3)
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

        $parkingAreas = ParkingArea::query()
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
            ])
            ->all();

        return inertia('home', [
            'stats' => [
                'upcoming_events' => Event::query()
                    ->whereNotNull('start_date')
                    ->where('start_date', '>=', Carbon::now()->startOfDay())
                    ->count(),
                'news_posts' => Post::query()->count(),
                'rubbish_streets' => RubbishStreet::query()->current()->count(),
                'parking_spaces' => ParkingArea::query()->sum('capacity'),
            ],
            'upcomingEvents' => $upcomingEvents,
            'latestNews' => $latestNews,
            'parkingAreas' => $parkingAreas,
            'mobileApps' => [
                'ios_url' => route('apps.ios'),
                'android_url' => route('apps.android'),
            ],
        ]);
    }
}
