<?php

use App\Models\Page;
use App\Models\PageBlock;
use App\Models\Tracker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Events\Models\Event;
use Modules\Events\Models\LivestreamSchedule;
use Modules\Locations\Models\Location;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;

use function Pest\Laravel\getJson;

beforeEach(function () {
    Storage::fake('media');

    config([
        'app.url' => 'https://moers.app',
        'festival.current_collection' => 'moers-festival-2026',
        'festival.stream.url' => 'https://moers.app/live/stream.m3u8',
        'festival.feed_aliases' => [3 => 3],
    ]);
});

function createFestivalEvent(array $overrides = []): Event
{
    $page = Page::factory()->published()->create([
        'title' => ['en' => 'Festival Event'],
        'slug' => ['en' => 'festival-event'],
        'summary' => ['en' => 'A festival page'],
    ]);

    PageBlock::factory()->published()->create([
        'page_id' => $page->id,
        'type' => 'tip-tap-text',
        'order' => 1,
        'data' => [
            'en' => [
                'text' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'paragraph',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => 'Festival body copy.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);

    $location = Location::factory()->create([
        'name' => ['en' => 'Festivalhalle'],
        'street_name' => 'Filder Str.',
        'street_number' => '142',
        'postalcode' => '47447',
        'postal_town' => 'Moers',
        'country_code' => 'DE',
        'lat' => 51.451,
        'lng' => 6.624,
        'tags' => ['en' => 'Hall'],
        'extras' => ['external_id' => 15],
    ]);

    $event = Event::factory()->published()->create(array_merge([
        'name' => ['en' => 'Opening Night'],
        'description' => ['en' => 'Kickoff concert'],
        'category' => ['en' => 'Concert'],
        'start_date' => now()->addDay()->setTime(18, 0),
        'end_date' => now()->addDay()->setTime(19, 30),
        'page_id' => $page->id,
        'place_id' => $location->id,
        'extras' => [
            'external_id' => 42,
            'lineup' => ['Artist One', 'Artist Two'],
            'collection' => 'moers-festival-2026',
            'open_end' => false,
        ],
    ], $overrides));

    $event
        ->addMedia(UploadedFile::fake()->image('event-header.jpg'))
        ->toMediaCollection('header');

    return $event;
}

test('festival events endpoints keep the legacy payload shape', function () {
    $event = createFestivalEvent();

    Event::factory()->published()->create([
        'name' => ['en' => 'Legacy Event'],
        'extras' => [
            'external_id' => 99,
            'collection' => 'moers-festival-2025',
        ],
    ]);

    $index = getJson('https://moers.app/api/v1/festival/events');

    $index->assertOk()
        ->assertJsonPath('data.0.id', $event->id)
        ->assertJsonPath('data.0.collection', 'festival26')
        ->assertJsonPath('data.0.extras.collection', 'festival26')
        ->assertJsonPath('data.0.place.id', $event->place_id)
        ->assertJsonPath('meta.path', 'https://moers.app/api/v1/festival/events');

    expect($index->json('data.0.media_collections.header.0.full_url'))
        ->toStartWith('https://moers.app/media/');

    getJson("https://moers.app/api/v1/festival/events/{$event->id}")
        ->assertOk()
        ->assertJsonPath('data.page.id', $event->page_id)
        ->assertJsonPath('data.place.id', $event->place_id)
        ->assertJsonPath('data.collection', 'festival26');

    getJson('https://moers.app/api/v1/festival/festival/content')
        ->assertOk()
        ->assertJsonPath('data.0.page.id', $event->page_id)
        ->assertJsonPath('data.0.page.blocks.0.type', 'tip-tap-text');

    $festivalEvent = getJson("https://moers.app/api/v1/festival/festival/events/{$event->id}");

    $festivalEvent->assertOk()
        ->assertJsonPath('data.event.id', $event->id)
        ->assertJsonPath('data.place.id', $event->place_id)
        ->assertJsonPath('data.page.id', $event->page_id);

    expect($festivalEvent->json('data.header.full_url'))
        ->toStartWith('https://moers.app/media/');
});

test('festival venues endpoints filter by the current collection', function () {
    $event = createFestivalEvent();

    $venueList = getJson('https://moers.app/api/v1/festival/locations');

    $venueList->assertOk()
        ->assertJsonPath('data.0.id', $event->place_id)
        ->assertJsonPath('data.0.events.0.id', $event->id)
        ->assertJsonPath('data.0.events.0.collection', 'festival26');

    getJson("https://moers.app/api/v1/festival/locations/{$event->place_id}")
        ->assertOk()
        ->assertJsonPath('data.id', $event->place_id)
        ->assertJsonPath('data.events.0.id', $event->id);

    getJson('https://moers.app/api/v1/festival/map/venues')
        ->assertOk()
        ->assertJsonPath('data.0.id', $event->place_id);

    getJson("https://moers.app/api/v1/festival/map/venues/{$event->place_id}")
        ->assertOk()
        ->assertJsonPath('data.events.0.id', $event->id);
});

test('festival pages and news endpoints are available under the compat prefix', function () {
    $event = createFestivalEvent();

    $feed = Feed::factory()->create([
        'id' => 7,
        'name' => ['en' => 'Festival News'],
    ]);

    $post = Post::factory()->published()->create([
        'title' => ['en' => 'Festival Update'],
        'summary' => ['en' => 'Important update'],
    ]);

    $post
        ->addMedia(UploadedFile::fake()->image('post-header.jpg'))
        ->toMediaCollection('header');

    $feed->posts()->attach($post->id, ['order' => 1]);

    config(['festival.feed_aliases' => [3 => $feed->id]]);

    getJson("https://moers.app/api/v1/festival/pages/{$event->page_id}")
        ->assertOk()
        ->assertJsonPath('data.id', $event->page_id)
        ->assertJsonPath('data.blocks.0.type', 'tip-tap-text');

    getJson('https://moers.app/api/v1/festival/feeds/3')
        ->assertOk()
        ->assertJsonPath('data.posts.data.0.id', $post->id);

    $feedPosts = getJson('https://moers.app/api/v1/festival/feeds/3/posts?page[size]=1&page[number]=1');

    $feedPosts->assertOk()
        ->assertJsonPath('data.0.id', $post->id)
        ->assertJsonPath('meta.path', 'https://moers.app/api/v1/festival/feeds/3/posts');

    expect($feedPosts->json('data.0.media_collections.header.0.full_url'))
        ->toStartWith('https://moers.app/media/');

    getJson("https://moers.app/api/v1/festival/posts/{$post->id}")
        ->assertOk()
        ->assertJsonPath('data.id', $post->id);
});

test('festival stream and tracker endpoints resolve from the new backend', function () {
    $event = createFestivalEvent();

    $schedule = LivestreamSchedule::factory()->create([
        'title' => 'Main Stream',
        'start_date' => now()->addHour(),
        'end_date' => now()->addHours(2),
    ]);

    $schedule->events()->attach($event->id);

    Tracker::query()->create([
        'device_id' => 'moers_festival_pax_counter_1',
        'name' => 'Tracker 1',
        'description' => 'Main gate',
        'is_enabled' => true,
        'type' => 'pax',
    ]);

    getJson('https://moers.app/api/v1/festival/stream')
        ->assertOk()
        ->assertJsonPath('url', 'https://moers.app/live/stream.m3u8')
        ->assertJsonPath('events.0.id', $event->id)
        ->assertJsonPath('events.0.collection', 'festival26');

    getJson('https://moers.app/api/v2/tracker')
        ->assertOk()
        ->assertJsonPath('0.device_id', 'moers_festival_pax_counter_1')
        ->assertJsonPath('0.is_enabled', true);
});
