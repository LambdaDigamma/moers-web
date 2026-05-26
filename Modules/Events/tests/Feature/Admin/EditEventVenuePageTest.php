<?php

use Database\Factories\UserFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Modules\Events\Models\Event;
use Modules\Locations\Models\Location;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    Storage::fake('media');
});

test('event venue edit page exposes location management data', function () {
    actingAs(UserFactory::new()->admin()->create());

    $location = Location::factory()->create([
        'name' => ['en' => 'Festivalhalle'],
        'lat' => 51.451,
        'lng' => 6.624,
        'country_code' => 'DE',
    ]);

    $location
        ->addMedia(UploadedFile::fake()->image('location-header.jpg'))
        ->toMediaCollection('header');

    $event = Event::factory()->create([
        'name' => ['en' => 'Opening Night'],
        'place_id' => $location->id,
    ]);

    get(route('events.venue.edit', $event))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('events/venue/edit')
            ->where('event.id', $event->id)
            ->where('canManageLocations', true)
            ->where('selectedLocation.id', $location->id)
            ->where('availableLocations.0.media_collections.header.0.collection_name', 'header'));
});
