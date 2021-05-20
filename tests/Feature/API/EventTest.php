<?php

use App\Models\Event;

use function Pest\Laravel\getJson;

test('get upcoming events', function () {

    Event::factory()->published()->upcomingStart()->count(10)->create();

    getJson('/api/v1/events')
        ->assertOk()
        ->assertJsonCount(10)
        ->assertJsonStructure([[
            'id',
            'name',
            'start_date',
            'end_date',
            'description',
            'page_id',
            'url',
            'image_path',
            'category',
            'organisation_id',
            'place_id',
            'platform_id',
            'extras',
            'scheduled_at'
        ]]);
});

test('get event', function () {
    $event = Event::factory()->published()->create();
    getJson("/api/v1/events/{$event->id}")
        ->assertOk()
        ->assertJsonStructure([
            'id',
            'name',
            'start_date',
            'end_date',
            'description',
            'page_id',
            'url',
            'image_path',
            'category',
            'organisation_id',
            'place_id',
            'platform_id',
            'extras',
            'scheduled_at'
        ]);
});