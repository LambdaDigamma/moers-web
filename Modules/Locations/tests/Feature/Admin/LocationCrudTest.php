<?php

use Database\Factories\UserFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Modules\Events\Models\Event;
use Modules\Locations\Models\Location;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    Storage::fake('media');
});

test('guests are redirected away from location management pages', function () {
    get(route('locations.create'))
        ->assertRedirect(route('login'));
});

test('authenticated non admins cannot access location management pages', function () {
    actingAs(UserFactory::new()->create());

    get(route('locations.create'))
        ->assertForbidden();
});

test('location create ignores protocol relative back urls', function () {
    actingAs(UserFactory::new()->admin()->create());

    get(route('locations.create', ['back' => '//example.test/admin']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('locations/create-location')
            ->where('backUrl', route('dashboard')));
});

test('admin users can create a location with multiple header images', function () {
    actingAs(UserFactory::new()->admin()->create());

    post(route('locations.store'), [
        'name' => 'Festivalhalle',
        'lat' => '51.451',
        'lng' => '6.624',
        'street_name' => 'Filder Str.',
        'street_number' => '142',
        'postalcode' => '47447',
        'postal_town' => 'Moers',
        'country_code' => 'DE',
        'url' => 'https://festivalhalle.example',
        'phone' => '+49 2841 123456',
        'tags' => 'Hall, Festival',
        'media' => [
            [
                'file' => UploadedFile::fake()->image('hero.jpg'),
                'alt' => 'Hero image',
                'caption' => 'Main stage',
                'credits' => 'Photographer One',
            ],
            [
                'file' => UploadedFile::fake()->image('secondary.jpg'),
                'alt' => 'Second image',
                'caption' => 'Audience area',
                'credits' => 'Photographer Two',
            ],
        ],
    ])->assertRedirect();

    $location = Location::query()->firstOrFail();
    $media = $location->getMedia('header');

    expect($location->name)->toBe('Festivalhalle')
        ->and($media)->toHaveCount(2)
        ->and($media[0]->alt)->toBe('Hero image')
        ->and($media[0]->caption)->toBe('Main stage')
        ->and($media[0]->credits)->toBe('Photographer One')
        ->and($media[1]->alt)->toBe('Second image');
});

test('admin users can update, reorder, remove, and add location header images', function () {
    actingAs(UserFactory::new()->admin()->create());

    $location = Location::factory()->create([
        'name' => ['en' => 'Festivalhalle'],
        'lat' => 51.451,
        'lng' => 6.624,
        'country_code' => 'DE',
    ]);

    $firstMedia = $location
        ->addMedia(UploadedFile::fake()->image('first.jpg'))
        ->toMediaCollection('header');

    $secondMedia = $location
        ->addMedia(UploadedFile::fake()->image('second.jpg'))
        ->toMediaCollection('header');

    put(route('locations.update', $location), [
        'name' => 'Festivalhalle Neu',
        'lat' => '51.452',
        'lng' => '6.625',
        'street_name' => 'Filder Str.',
        'street_number' => '144',
        'postalcode' => '47447',
        'postal_town' => 'Moers',
        'country_code' => 'DE',
        'url' => 'https://festivalhalle-neu.example',
        'phone' => '+49 2841 654321',
        'tags' => 'Festival',
        'media' => [
            [
                'id' => $secondMedia->id,
                'alt' => 'New hero',
                'caption' => 'Front entrance',
                'credits' => 'Photographer Two',
            ],
            [
                'file' => UploadedFile::fake()->image('third.jpg'),
                'alt' => 'Third image',
                'caption' => 'Balcony',
                'credits' => 'Photographer Three',
            ],
        ],
    ])->assertRedirect();

    $location->refresh();
    $media = $location->getMedia('header')->sortBy('order_column')->values();

    expect($location->name)->toBe('Festivalhalle Neu')
        ->and($media)->toHaveCount(2)
        ->and($media[0]->id)->toBe($secondMedia->id)
        ->and($media[0]->alt)->toBe('New hero')
        ->and($media[1]->file_name)->toBe('third.jpg')
        ->and($location->getMedia('header')->pluck('id'))->not->toContain($firstMedia->id);
});

test('admin users can update location fields without changing existing media', function () {
    actingAs(UserFactory::new()->admin()->create());

    $location = Location::factory()->create([
        'name' => ['en' => 'Festivalhalle'],
        'lat' => 51.451,
        'lng' => 6.624,
        'country_code' => 'DE',
    ]);

    $media = $location
        ->addMedia(UploadedFile::fake()->image('hero.jpg'))
        ->toMediaCollection('header');

    put(route('locations.update', $location), [
        'name' => 'Festivalhalle Neu',
        'lat' => '51.452',
        'lng' => '6.625',
        'country_code' => 'DE',
    ])->assertRedirect();

    $location->refresh();

    expect($location->name)->toBe('Festivalhalle Neu')
        ->and($location->getMedia('header'))->toHaveCount(1)
        ->and($location->getFirstMedia('header')?->id)->toBe($media->id);
});

test('admin users do not persist location changes when media sync fails', function () {
    actingAs(UserFactory::new()->admin()->create());

    $location = Location::factory()->create([
        'name' => ['en' => 'Festivalhalle'],
        'lat' => 51.451,
        'lng' => 6.624,
        'country_code' => 'DE',
    ]);

    $otherLocation = Location::factory()->create([
        'name' => ['en' => 'Other location'],
        'lat' => 51.452,
        'lng' => 6.625,
        'country_code' => 'DE',
    ]);

    $foreignMedia = $otherLocation
        ->addMedia(UploadedFile::fake()->image('foreign.jpg'))
        ->toMediaCollection('header');

    from(route('locations.edit', $location))
        ->put(route('locations.update', $location), [
            'name' => 'Should not persist',
            'lat' => '51.453',
            'lng' => '6.626',
            'country_code' => 'DE',
            'sync_media' => true,
            'media' => [
                ['id' => $foreignMedia->id],
            ],
        ])
        ->assertRedirect(route('locations.edit', $location))
        ->assertSessionHasErrors('media');

    $location->refresh();

    expect($location->name)->toBe('Festivalhalle')
        ->and((float) $location->lat)->toBe(51.451);
});

test('admin users do not create a location when media sync fails', function () {
    actingAs(UserFactory::new()->admin()->create());

    from(route('locations.create'))
        ->post(route('locations.store'), [
            'name' => 'Festivalhalle',
            'lat' => '51.451',
            'lng' => '6.624',
            'country_code' => 'DE',
            'sync_media' => true,
            'media' => [
                ['id' => 999999],
            ],
        ])
        ->assertRedirect(route('locations.create'))
        ->assertSessionHasErrors('media');

    expect(Location::query()->count())->toBe(0);
});

test('malformed media entries return validation errors', function () {
    actingAs(UserFactory::new()->admin()->create());

    $location = Location::factory()->create([
        'name' => ['en' => 'Festivalhalle'],
        'lat' => 51.451,
        'lng' => 6.624,
        'country_code' => 'DE',
    ]);

    from(route('locations.edit', $location))
        ->put(route('locations.update', $location), [
            'name' => 'Festivalhalle',
            'lat' => '51.451',
            'lng' => '6.624',
            'country_code' => 'DE',
            'sync_media' => true,
            'media' => ['not-valid-media-data'],
        ])
        ->assertRedirect(route('locations.edit', $location))
        ->assertSessionHasErrors('media.0');
});

test('admin users cannot delete a location that is still assigned to events', function () {
    actingAs(UserFactory::new()->admin()->create());

    $location = Location::factory()->create([
        'name' => ['en' => 'Festivalhalle'],
        'lat' => 51.451,
        'lng' => 6.624,
        'country_code' => 'DE',
    ]);

    Event::factory()->published()->create([
        'place_id' => $location->id,
    ]);

    from(route('locations.edit', $location))
        ->delete(route('locations.destroy', $location))
        ->assertRedirect(route('locations.edit', $location))
        ->assertSessionHasErrors('location');

    expect($location->fresh())->not->toBeNull();
});

test('admin users cannot delete a location that is still assigned to an unpublished event', function () {
    actingAs(UserFactory::new()->admin()->create());

    $location = Location::factory()->create([
        'name' => ['en' => 'Festivalhalle'],
        'lat' => 51.451,
        'lng' => 6.624,
        'country_code' => 'DE',
    ]);

    Event::factory()->notPublished()->create([
        'place_id' => $location->id,
    ]);

    from(route('locations.edit', $location))
        ->delete(route('locations.destroy', $location))
        ->assertRedirect(route('locations.edit', $location))
        ->assertSessionHasErrors('location');

    expect($location->fresh())->not->toBeNull();
});

test('admin users cannot delete a location that is still assigned to a hidden deleted event', function () {
    actingAs(UserFactory::new()->admin()->create());

    $location = Location::factory()->create([
        'name' => ['en' => 'Festivalhalle'],
        'lat' => 51.451,
        'lng' => 6.624,
        'country_code' => 'DE',
    ]);

    $event = Event::factory()->notPublished()->archived()->create([
        'place_id' => $location->id,
    ]);
    $event->delete();

    from(route('locations.edit', $location))
        ->delete(route('locations.destroy', $location))
        ->assertRedirect(route('locations.edit', $location))
        ->assertSessionHasErrors('location');

    expect($location->fresh())->not->toBeNull();
});

test('location create keeps hidden event context', function () {
    actingAs(UserFactory::new()->admin()->create());

    $event = Event::factory()->notPublished()->archived()->create();
    $event->delete();

    get(route('locations.create', ['event' => $event->id]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('locations/create-location')
            ->where('returnToEvent.id', $event->id));
});

test('admin users can delete an unused location', function () {
    actingAs(UserFactory::new()->admin()->create());

    $location = Location::factory()->create([
        'name' => ['en' => 'Festivalhalle'],
        'lat' => 51.451,
        'lng' => 6.624,
        'country_code' => 'DE',
    ]);

    delete(route('locations.destroy', $location))
        ->assertRedirect(route('dashboard'));

    expect(Location::withTrashed()->find($location->id)?->trashed())->toBeTrue();
});
