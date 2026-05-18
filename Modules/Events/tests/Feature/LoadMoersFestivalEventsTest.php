<?php

use Modules\Events\Enums\ScheduleDisplay;
use Modules\Events\Integrations\MoersFestival\Requests\GetEventsRequest;
use Modules\Events\Models\Event;
use Modules\Locations\Models\Location;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

use function Pest\Laravel\artisan;
use function Pest\Laravel\getJson;

it('stores imported Moers Festival event dates as UTC and exposes UTC API dates', function () {
    config([
        'app.timezone' => 'UTC',
        'app.url' => 'https://moers.app',
        'festival.current_collection' => 'moers-festival-2026',
    ]);

    Saloon::fake([
        GetEventsRequest::class => MockResponse::make([
            [
                'id' => 402,
                'event' => 4,
                'title' => 'WDR Big Band feat. Nduduzo Makhathini',
                'subline' => '',
                'subline_en' => '',
                'standort' => 0,
                'time_start' => '2026-05-21 18:30:00',
                'time_end' => '2026-05-21 19:35:00',
                'open_end' => 0,
                'sametime' => '',
                'media' => '',
                'besetzung' => 'WDR Big Band',
                'text' => '',
                'text_en' => '',
                'lastchanged' => '2026-04-23 13:09:08',
                'url_de' => '',
                'url_en' => '',
                'standort_name' => 'Buehne Kastellplatz',
                'standort_adresse' => 'Kastellplatz',
                'standort_city' => 'Moers',
                'standort_plz' => '47441',
                'standort_lng' => '6.625807',
                'standort_lat' => '51.450477',
                'preview' => 0,
            ],
        ]),
    ]);

    artisan('events:load-moers-festival-events', ['--skip-previous-years' => true])
        ->assertSuccessful();

    Saloon::assertSent(GetEventsRequest::class);

    $event = Event::query()
        ->where('extras->external_id', 402)
        ->where('extras->collection', 'moers-festival-2026')
        ->firstOrFail();

    expect($event->getRawOriginal('start_date'))->toBe('2026-05-21 16:30:00')
        ->and($event->getRawOriginal('end_date'))->toBe('2026-05-21 17:35:00')
        ->and($event->extras->get('schedule_display'))->toBe(ScheduleDisplay::DATE_TIME->value);

    getJson('https://moers.app/api/v1/festival/events')
        ->assertOk()
        ->assertJsonPath('data.0.id', $event->id)
        ->assertJsonPath('data.0.start_date', '2026-05-21T16:30:00.000000Z')
        ->assertJsonPath('data.0.end_date', '2026-05-21T17:35:00.000000Z')
        ->assertJsonPath('data.0.extras.schedule_display', ScheduleDisplay::DATE_TIME->value);
});

it('preserves manually edited Moers Festival location fields when incoming venue values are blank', function (mixed $blankValue) {
    config([
        'app.timezone' => 'UTC',
        'app.url' => 'https://moers.app',
        'festival.current_collection' => 'moers-festival-2026',
    ]);

    $location = Location::factory()->create([
        'name' => 'Manual Festivalhalle',
        'street_name' => 'Manual Street 12',
        'postalcode' => '47441',
        'postal_town' => 'Moers',
        'country_code' => 'NL',
        'lat' => 51.451234,
        'lng' => 6.624567,
        'extras' => ['external_id' => 15],
    ]);

    Saloon::fake([
        GetEventsRequest::class => MockResponse::make([
            moersFestivalEventPayload([
                'id' => 502,
                'standort' => 15,
                'standort_name' => $blankValue,
                'standort_adresse' => $blankValue,
                'standort_city' => $blankValue,
                'standort_plz' => $blankValue,
                'standort_lng' => $blankValue,
                'standort_lat' => $blankValue,
            ]),
        ]),
    ]);

    artisan('events:load-moers-festival-events', ['--skip-previous-years' => true])
        ->assertSuccessful();

    Saloon::assertSent(GetEventsRequest::class);

    $event = Event::query()
        ->where('extras->external_id', 502)
        ->where('extras->collection', 'moers-festival-2026')
        ->firstOrFail();

    $location->refresh();

    expect(Location::query()->count())->toBe(1)
        ->and($event->place_id)->toBe($location->id)
        ->and($location->street_name)->toBe('Manual Street 12')
        ->and($location->postalcode)->toBe('47441')
        ->and($location->postal_town)->toBe('Moers')
        ->and($location->country_code)->toBe('NL')
        ->and($location->lat)->toEqual(51.451234)
        ->and($location->lng)->toEqual(6.624567);
})->with([
    'empty strings' => [''],
    'nulls' => [null],
]);

it('updates filled Moers Festival location values while preserving blank address fields and incomplete coordinates', function () {
    config([
        'app.timezone' => 'UTC',
        'app.url' => 'https://moers.app',
        'festival.current_collection' => 'moers-festival-2026',
    ]);

    $location = Location::factory()->create([
        'name' => 'Manual Old Stage',
        'street_name' => 'Manual Address 7',
        'postalcode' => '47441',
        'postal_town' => 'Moers',
        'country_code' => 'NL',
        'lat' => 51.451234,
        'lng' => 6.624567,
        'extras' => ['external_id' => 16],
    ]);

    Saloon::fake([
        GetEventsRequest::class => MockResponse::make([
            moersFestivalEventPayload([
                'id' => 503,
                'standort' => 16,
                'standort_name' => 'Updated Festival Stage',
                'standort_adresse' => '',
                'standort_city' => 'Neukirchen-Vluyn',
                'standort_plz' => '',
                'standort_lng' => '6.700000',
                'standort_lat' => '',
            ]),
        ]),
    ]);

    artisan('events:load-moers-festival-events', ['--skip-previous-years' => true])
        ->assertSuccessful();

    Saloon::assertSent(GetEventsRequest::class);

    $event = Event::query()
        ->where('extras->external_id', 503)
        ->where('extras->collection', 'moers-festival-2026')
        ->firstOrFail();

    $location->refresh();

    expect(Location::query()->count())->toBe(1)
        ->and($event->place_id)->toBe($location->id)
        ->and($location->name)->toBe('Updated Festival Stage')
        ->and($location->postal_town)->toBe('Neukirchen-Vluyn')
        ->and($location->street_name)->toBe('Manual Address 7')
        ->and($location->postalcode)->toBe('47441')
        ->and($location->country_code)->toBe('NL')
        ->and($location->lat)->toEqual(51.451234)
        ->and($location->lng)->toEqual(6.624567);
});

function moersFestivalEventPayload(array $overrides = []): array
{
    return array_replace([
        'id' => 402,
        'event' => 4,
        'title' => 'WDR Big Band feat. Nduduzo Makhathini',
        'subline' => '',
        'subline_en' => '',
        'standort' => 0,
        'time_start' => '2026-05-21 18:30:00',
        'time_end' => '2026-05-21 19:35:00',
        'open_end' => 0,
        'sametime' => '',
        'media' => '',
        'besetzung' => 'WDR Big Band',
        'text' => '',
        'text_en' => '',
        'lastchanged' => '2026-04-23 13:09:08',
        'url_de' => '',
        'url_en' => '',
        'standort_name' => 'Buehne Kastellplatz',
        'standort_adresse' => 'Kastellplatz',
        'standort_city' => 'Moers',
        'standort_plz' => '47441',
        'standort_lng' => '6.625807',
        'standort_lat' => '51.450477',
        'preview' => 0,
    ], $overrides);
}
