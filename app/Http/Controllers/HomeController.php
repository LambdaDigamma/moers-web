<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Inertia\Response;
use Modules\Events\Models\Event;
use Modules\Management\Models\Organisation;
use Modules\News\Models\Post;
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
                'location' => $event->place?->name,
            ])
            ->all();

        $latestNews = Post::query()
            ->orderByDesc('published_at')
            ->limit(3)
            ->get()
            ->map(fn (Post $post) => [
                'id' => $post->id,
                'title' => $post->title,
                'summary' => $post->summary,
                'published_at' => $post->published_at?->toIso8601String(),
            ])
            ->all();

        $featuredOrganisations = Organisation::query()
            ->orderBy('name')
            ->limit(6)
            ->get()
            ->map(fn (Organisation $organisation) => [
                'id' => $organisation->id,
                'name' => $organisation->name,
                'slug' => $organisation->slug,
                'description' => $organisation->description,
            ])
            ->all();

        return inertia('home', [
            'stats' => [
                'upcoming_events' => Event::query()
                    ->whereNotNull('start_date')
                    ->where('start_date', '>=', Carbon::now()->startOfDay())
                    ->count(),
                'news_posts' => Post::query()->count(),
                'organisations' => Organisation::query()->count(),
                'rubbish_streets' => RubbishStreet::query()->current()->count(),
            ],
            'upcomingEvents' => $upcomingEvents,
            'latestNews' => $latestNews,
            'featuredOrganisations' => $featuredOrganisations,
            'mobileApps' => [
                'ios_url' => route('apps.ios'),
                'android_url' => route('apps.android'),
            ],
        ]);
    }
}
