<?php

use Illuminate\Support\Carbon;
use Inertia\Testing\AssertableInertia as Assert;
use Modules\Events\Models\Event;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;
use Modules\Parking\Models\ParkingArea;
use Modules\Waste\Models\RubbishStreet;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;
use function Pest\Laravel\travelTo;

it('renders Inertia-managed SEO head elements', function () {
    get('/')
        ->assertSuccessful()
        ->assertSee('<title data-inertia', false)
        ->assertSee('data-inertia="description"', false)
        ->assertSee('data-inertia="og:title"', false)
        ->assertSee('data-inertia="twitter:card"', false)
        ->assertDontSee('@trail')
        ->assertDontSee('<title inertia>', false);
});

it('shows the public landing page with overview data', function () {
    travelTo(Carbon::parse('2026-03-08 10:00:00'));

    Event::factory()->published()->create([
        'name' => 'Fruehlingskonzert',
        'start_date' => Carbon::parse('2026-03-09 19:30:00'),
    ]);
    Event::factory()->published()->create([
        'name' => 'Vergangenes Event',
        'start_date' => Carbon::parse('2026-03-01 12:00:00'),
    ]);

    $post = Post::factory()->published()->create([
        'title' => 'Neue Meldung',
        'summary' => 'Wichtige Information aus Moers',
        'external_href' => 'https://example.com/news/neue-meldung',
    ]);
    Feed::factory()->create([
        'name' => 'NRZ',
    ])->posts()->attach($post, ['order' => 0]);
    Post::factory()->notPublished()->create([
        'title' => 'Interner Entwurf',
    ]);

    ParkingArea::factory()->open()->create([
        'name' => 'Kastell',
        'capacity' => 340,
        'occupied_sites' => 212,
    ]);
    ParkingArea::factory()->closed()->create([
        'name' => 'Bankstrasse',
        'capacity' => 120,
        'occupied_sites' => 0,
    ]);

    RubbishStreet::factory()->create(['name' => 'Musterweg']);
    RubbishStreet::factory()->old()->create(['name' => 'Alte Strasse']);

    get('/')
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('home')
            ->where('stats.upcoming_events', 1)
            ->where('stats.events_today_and_tomorrow', 1)
            ->where('stats.news_posts', 1)
            ->where('stats.rubbish_streets', 1)
            ->where('stats.parking_spaces', 460)
            ->where('stats.free_parking_spaces', 128)
            ->where('stats.open_parking_areas', 1)
            ->where('selectedEventDay', 'all')
            ->where('eventDayFilters.1.label', 'Heute')
            ->where('eventDayFilters.2.label', 'Morgen')
            ->has('upcomingEvents', 1)
            ->where('upcomingEvents.0.name', 'Fruehlingskonzert')
            ->has('upcomingEvents.0.category')
            ->has('latestNews', 1)
            ->where('latestNews.0.title', 'Neue Meldung')
            ->where('latestNews.0.external_href', 'https://example.com/news/neue-meldung')
            ->where('latestNews.0.header_image_url', null)
            ->where('latestNews.0.source_name', 'NRZ')
            ->has('parkingAreas', 2)
            ->where('parkingAreas.0.name', 'Kastell')
            ->has('parkingAreas.0.updated_at')
            ->where('mobileApps.ios_url', route('apps.ios'))
            ->where('mobileApps.android_url', route('apps.android')));
});

it('filters landing page events before limiting the results', function (string $day, int $expectedCount) {
    travelTo(Carbon::parse('2026-03-08 10:00:00'));

    foreach (['2026-03-08' => 6, '2026-03-09' => 8, '2026-03-12' => 8] as $eventDay => $count) {
        Event::factory()->published()->count($count)->sequence(
            fn ($sequence) => ['start_date' => Carbon::parse($eventDay.' 10:00:00')->addMinutes($sequence->index)],
        )->create();
    }

    get(route('home', ['event_day' => $day]))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('home')
            ->where('selectedEventDay', $day)
            ->where('stats.upcoming_events', 22)
            ->where('stats.events_today_and_tomorrow', 14)
            ->where('eventDayFilters.3.key', '2026-03-12')
            ->has('upcomingEvents', $expectedCount)
            ->where('upcomingEvents', fn ($events) => collect($events)->every(
                fn ($event) => str_starts_with($event['start_date'], $day),
            )));
})->with([
    'today' => ['2026-03-08', 6],
    'tomorrow after six earlier events' => ['2026-03-09', 6],
    'later day outside the initial six events' => ['2026-03-12', 6],
    'day without events' => ['2026-03-10', 0],
]);

it('returns only the event props when changing the landing page day filter', function () {
    travelTo(Carbon::parse('2026-03-08 10:00:00'));

    Event::factory()->published()->count(6)->create([
        'start_date' => Carbon::parse('2026-03-08 12:00:00'),
    ]);
    Event::factory()->published()->create([
        'name' => 'Konzert morgen',
        'start_date' => Carbon::parse('2026-03-09 19:00:00'),
    ]);

    $version = get('/')->viewData('page')['version'];

    get(route('home', ['event_day' => '2026-03-09']), [
        'X-Inertia' => 'true',
        'X-Inertia-Version' => $version,
        'X-Inertia-Partial-Component' => 'home',
        'X-Inertia-Partial-Data' => 'upcomingEvents,selectedEventDay',
    ])
        ->assertSuccessful()
        ->assertJsonPath('component', 'home')
        ->assertJsonPath('props.selectedEventDay', '2026-03-09')
        ->assertJsonCount(1, 'props.upcomingEvents')
        ->assertJsonPath('props.upcomingEvents.0.name', 'Konzert morgen')
        ->assertJsonMissingPath('props.stats')
        ->assertJsonMissingPath('props.eventDayFilters')
        ->assertJsonMissingPath('props.latestNews')
        ->assertJsonMissingPath('props.parkingAreas');
});

it('rejects invalid landing page event dates', function (string $day) {
    getJson(route('home', ['event_day' => $day]))
        ->assertUnprocessable()
        ->assertInvalid(['event_day']);
})->with(['not-a-date', '2026-02-30', '2026-3-9']);

it('limits the landing page to six upcoming events and five news posts', function () {
    travelTo(Carbon::parse('2026-03-08 10:00:00'));

    Event::factory()->published()->count(8)->sequence(
        fn ($sequence) => ['start_date' => Carbon::parse('2026-03-09 10:00:00')->addDays($sequence->index)],
    )->create();
    Post::factory()->published()->count(7)->create();

    get('/')
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('home')
            ->where('stats.upcoming_events', 8)
            ->where('stats.events_today_and_tomorrow', 1)
            ->has('upcomingEvents', 6)
            ->has('latestNews', 5));
});
