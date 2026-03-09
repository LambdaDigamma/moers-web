<?php

use Illuminate\Support\Carbon;
use Inertia\Testing\AssertableInertia as Assert;
use Modules\Events\Models\Event;
use Modules\Management\Models\Organisation;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;
use Modules\Waste\Models\RubbishStreet;

use function Pest\Laravel\get;
use function Pest\Laravel\travelTo;

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

    Organisation::factory()->create([
        'name' => 'Kulturverein',
        'slug' => 'kulturverein',
    ]);

    RubbishStreet::factory()->create(['name' => 'Musterweg']);
    RubbishStreet::factory()->old()->create(['name' => 'Alte Strasse']);

    get('/')
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('home')
            ->where('stats.upcoming_events', 1)
            ->where('stats.news_posts', 1)
            ->where('stats.organisations', 1)
            ->where('stats.rubbish_streets', 1)
            ->has('upcomingEvents', 1)
            ->where('upcomingEvents.0.name', 'Fruehlingskonzert')
            ->has('latestNews', 1)
            ->where('latestNews.0.title', 'Neue Meldung')
            ->where('latestNews.0.external_href', 'https://example.com/news/neue-meldung')
            ->where('latestNews.0.header_image_url', null)
            ->where('latestNews.0.source_name', 'NRZ')
            ->has('featuredOrganisations', 1)
            ->where('featuredOrganisations.0.slug', 'kulturverein')
            ->where('mobileApps.ios_url', route('apps.ios'))
            ->where('mobileApps.android_url', route('apps.android')));
});
