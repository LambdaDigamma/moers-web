<?php

use Database\Factories\UserFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Modules\Locations\Models\Location;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

beforeEach(function () {
    Storage::fake('media');
});

test('authenticated locations api responses include header media collections', function () {
    Sanctum::actingAs(UserFactory::new()->create());

    $location = Location::factory()->create([
        'name' => ['en' => 'Festivalhalle'],
        'lat' => 51.451,
        'lng' => 6.624,
        'country_code' => 'DE',
    ]);

    $location
        ->addMedia(UploadedFile::fake()->image('location-header.jpg'))
        ->toMediaCollection('header');

    getJson(route('api.locations.index'))
        ->assertOk()
        ->assertJsonPath('0.id', $location->id)
        ->assertJsonPath('0.media_collections.header.0.collection_name', 'header');

    getJson(route('api.locations.show', $location))
        ->assertOk()
        ->assertJsonPath('id', $location->id)
        ->assertJsonPath('media_collections.header.0.collection_name', 'header');
});

test('authenticated locations api is read only', function () {
    Sanctum::actingAs(UserFactory::new()->create());

    postJson('/api/v1/locations', [
        'name' => 'Festivalhalle',
    ])->assertStatus(405);
});
