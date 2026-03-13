<?php

use Illuminate\Support\Carbon;
use Inertia\Testing\AssertableInertia as Assert;
use Modules\Events\Models\Event;
use Modules\Locations\Models\Location;
use Modules\Management\Models\Organisation;

use function Pest\Laravel\get;
use function Pest\Laravel\travelTo;

it('shows filtered public events with available filter options', function () {
    travelTo(Carbon::parse('2026-03-08 10:00:00'));

    $organisation = Organisation::factory()->create([
        'name' => 'Moers Festival',
        'slug' => 'moers-festival',
    ]);

    $location = Location::factory()->create([
        'name' => 'Festivalhalle',
        'street_name' => 'Kastell 3',
        'postalcode' => '47441',
        'postal_town' => 'Moers',
    ]);

    Event::factory()->published()->create([
        'name' => 'Jazznacht',
        'description' => 'Live in der Innenstadt',
        'start_date' => Carbon::parse('2026-04-12 19:30:00'),
        'end_date' => Carbon::parse('2026-04-12 22:00:00'),
        'category' => ['de' => 'Konzert', 'en' => 'Konzert'],
        'organisation_id' => $organisation->id,
        'place_id' => $location->id,
        'extras' => collect([
            'collection' => 'moers-festival-2026',
            'lineup' => ['Band A'],
        ]),
    ]);

    Event::factory()->published()->create([
        'name' => 'Buergersprechstunde',
        'start_date' => Carbon::parse('2026-04-13 10:00:00'),
    ]);

    get("/events?search=Jazz&type=upcoming&collection=moers-festival-2026&organisation={$organisation->id}&location={$location->id}")
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('events/index')
            ->where('filters.search', 'Jazz')
            ->where('filters.type', 'upcoming')
            ->where('filters.collection', 'moers-festival-2026')
            ->where('filters.organisation', (string) $organisation->id)
            ->where('filters.location', (string) $location->id)
            ->has('events.data', 1)
            ->where('events.data.0.name', 'Jazznacht')
            ->where('events.data.0.collection', 'moers-festival-2026')
            ->where('events.data.0.organisationName', 'Moers Festival')
            ->where('events.data.0.locationName', 'Festivalhalle')
            ->has('availableFilters.types', 3)
            ->has('availableFilters.collections', 1)
            ->where('availableFilters.collections.0', 'moers-festival-2026')
            ->has('availableFilters.organisations', 1)
            ->where('availableFilters.organisations.0.label', 'Moers Festival')
            ->has('availableFilters.locations', 1)
            ->where('availableFilters.locations.0.label', 'Festivalhalle'));
});

it('shows a public event detail page with real metadata', function () {
    $organisation = Organisation::factory()->create([
        'name' => 'Moers Festival',
        'slug' => 'moers-festival',
    ]);

    $location = Location::factory()->create([
        'name' => 'Festivalhalle',
        'street_name' => 'Kastell 3',
        'postalcode' => '47441',
        'postal_town' => 'Moers',
        'lat' => 51.451,
        'lng' => 6.628,
    ]);

    $event = Event::factory()->published()->create([
        'name' => 'Jazznacht',
        'description' => 'Live in der Innenstadt',
        'url' => 'https://example.com/jazznacht',
        'start_date' => Carbon::parse('2026-04-12 19:30:00'),
        'end_date' => Carbon::parse('2026-04-12 22:00:00'),
        'category' => ['de' => 'Konzert', 'en' => 'Konzert'],
        'organisation_id' => $organisation->id,
        'place_id' => $location->id,
        'extras' => collect([
            'collection' => 'moers-festival-2026',
            'teaser' => 'Ein Abend zwischen Festivalenergie und Clubkonzert.',
            'lineup' => ['Band A', 'Band B'],
            'organizer_street' => 'Kastell 5',
            'organizer_postcode' => '47441',
            'organizer_place' => 'Moers',
            'organizer_phone' => '+49 2841 123456',
            'organizer_email' => 'tickets@festival.test',
            'organizer_website' => 'https://festival.test',
        ]),
    ]);

    get("/events/{$event->id}?back=%2Fevents%3Fcollection%3Dmoers-festival-2026")
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('events/show-event')
            ->where('backUrl', '/events?collection=moers-festival-2026')
            ->where('event.name', 'Jazznacht')
            ->where('event.category', 'Konzert')
            ->where('event.collection', 'moers-festival-2026')
            ->where('event.organisationName', 'Moers Festival')
            ->where('event.organisationSlug', 'moers-festival')
            ->where('event.locationName', 'Festivalhalle')
            ->where('event.street', 'Kastell 3')
            ->where('event.postcode', '47441')
            ->where('event.city', 'Moers')
            ->where('event.teaser', 'Ein Abend zwischen Festivalenergie und Clubkonzert.')
            ->where('event.url', 'https://example.com/jazznacht')
            ->where('event.artists.0', 'Band A')
            ->where('event.organizerStreet', 'Kastell 5')
            ->where('event.organizerPostcode', '47441')
            ->where('event.organizerCity', 'Moers')
            ->where('event.organizerPhone', '+49 2841 123456')
            ->where('event.organizerEmail', 'tickets@festival.test')
            ->where('event.organizerWebsite', 'https://festival.test')
            ->where('event.calendarUrl', fn ($value) => is_string($value) && str_starts_with($value, 'data:text/calendar;charset=utf8;base64,')));
});

it('falls back from legacy preview flags to a date-only schedule on public pages', function () {
    $event = Event::factory()->published()->create([
        'name' => 'Preview Konzert',
        'start_date' => Carbon::parse('2026-04-12 19:30:00'),
        'end_date' => Carbon::parse('2026-04-12 22:00:00'),
        'extras' => collect([
            'collection' => 'moers-festival-2026',
            'is_preview' => true,
        ]),
    ]);

    get("/events/{$event->id}")
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('events/show-event')
            ->where('event.name', 'Preview Konzert')
            ->where('event.startDate', fn ($value) => is_string($value))
            ->where('event.endDate', fn ($value) => is_string($value))
            ->where('event.scheduleDisplay', 'date')
            ->where('event.showsDateComponent', true)
            ->where('event.showsTimeComponent', false)
            ->where('event.calendarUrl', null));

    get('/events?type=all')
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('events/index')
            ->where('events.data.0.startDate', fn ($value) => is_string($value))
            ->where('events.data.0.endDate', fn ($value) => is_string($value))
            ->where('events.data.0.scheduleDisplay', 'date')
            ->where('events.data.0.showsDateComponent', true)
            ->where('events.data.0.showsTimeComponent', false)
            ->where('events.data.0.calendarUrl', null));
});

it('handles events with null description correctly', function () {
    $event = Event::factory()->published()->create([
        'name' => 'Event ohne Beschreibung',
        'description' => null,
        'start_date' => Carbon::parse('2026-04-12 19:30:00'),
    ]);

    get('/events?type=all')
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('events/index')
            ->has('events.data', 1)
            ->where('events.data.0.name', 'Event ohne Beschreibung')
            ->where('events.data.0.calendarUrl', fn ($value) => is_string($value)));
});
