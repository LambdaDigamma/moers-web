<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Modules\Events\Jobs\LoadMoersEvent;
use Modules\Events\Models\Event;

use function Pest\Laravel\artisan;
use function Pest\Laravel\getJson;

it('requests only published Moers events from the upstream listing', function () {
    Bus::fake();

    Http::fake([
        'https://www.moers.de/jsonapi/node/event*' => Http::response([
            'jsonapi' => ['version' => '1.0'],
            'data' => [
                [
                    'type' => 'node--event',
                    'id' => 'event-1',
                    'links' => [
                        'self' => [
                            'href' => 'https://www.moers.de/jsonapi/node/event/event-1?resourceVersion=id%3A1',
                        ],
                    ],
                ],
            ],
            'links' => [
                'self' => [
                    'href' => 'https://www.moers.de/jsonapi/node/event?filter%5Bstatus%5D=1',
                ],
            ],
        ], 200, moersJsonApiHeaders()),
    ]);

    artisan('events:load-moers-events')
        ->assertSuccessful();

    Http::assertSent(fn (Request $request) => str_contains(
        rawurldecode($request->url()),
        'filter[status]=1',
    ));

    Bus::assertDispatched(
        LoadMoersEvent::class,
        fn (LoadMoersEvent $job) => $job->href === 'https://www.moers.de/jsonapi/node/event/event-1?resourceVersion=id%3A1',
    );
});

it('imports structured Moers venue content category and organizer data', function () {
    config(['app.url' => 'https://moers.app']);

    $eventHref = 'https://www.moers.de/jsonapi/node/event/event-1?resourceVersion=id%3A1';
    $venueHref = 'https://www.moers.de/jsonapi/node/event/event-1/field_evt_media_venue_ref?resourceVersion=id%3A1';
    $organizerHref = 'https://www.moers.de/jsonapi/node/event/event-1/field_evt_media_organizer_ref?resourceVersion=id%3A1';
    $organizerAddressHref = 'https://www.moers.de/jsonapi/media/company/organizer-1/field_msf_address_ref?resourceVersion=id%3A2';
    $contentHref = 'https://www.moers.de/jsonapi/node/event/event-1/field_nsf_content_ref?resourceVersion=id%3A1';
    $typeHref = 'https://www.moers.de/jsonapi/node/event/event-1/field_evt_type_ref?resourceVersion=id%3A1';

    Http::preventStrayRequests();
    Http::fake([
        $eventHref => Http::response(moersJsonApiDocument(moersEventResource([
            'relationships' => [
                'field_evt_media_venue_ref' => moersRelationship($venueHref),
                'field_evt_media_organizer_ref' => moersRelationship($organizerHref),
                'field_nsf_content_ref' => moersRelationship($contentHref, true),
                'field_evt_type_ref' => moersRelationship($typeHref, true),
            ],
        ])), 200, moersJsonApiHeaders()),
        $venueHref => Http::response(moersJsonApiDocument(moersAddressResource([
            'id' => 'venue-1',
            'name' => 'Markt 1-3, 47445 Moers',
            'field_add_address' => [
                'street' => 'Markt',
                'houseNumber' => '1',
                'houseNumberAddition' => '-3',
                'zip' => '47445',
                'city' => 'Moers',
            ],
            'field_add_geo' => [
                'lat' => 51.489071,
                'lon' => 6.601121,
            ],
        ])), 200, moersJsonApiHeaders()),
        $organizerHref => Http::response(moersJsonApiDocument(moersCompanyResource([
            'id' => 'organizer-1',
            'name' => 'WMV Märkte & Mehr UG',
            'field_com_company' => 'WMV Märkte & Mehr UG',
            'field_msf_email' => 'wmv@example.test',
            'field_msf_homepage' => ['uri' => 'https://example.test'],
            'field_msf_phone' => '0 21 52 / 15 91',
            'relationships' => [
                'field_msf_address_ref' => moersRelationship($organizerAddressHref),
            ],
        ])), 200, moersJsonApiHeaders()),
        $organizerAddressHref => Http::response(moersJsonApiDocument(moersAddressResource([
            'id' => 'organizer-address-1',
            'name' => 'Hooghe Weg 2, 47906 Kempen',
            'field_add_address' => [
                'street' => 'Hooghe Weg',
                'houseNumber' => '2',
                'zip' => '47906',
                'city' => 'Kempen',
            ],
        ])), 200, moersJsonApiHeaders()),
        $contentHref => Http::response(moersJsonApiDocument([
            [
                'type' => 'paragraph--text',
                'id' => 'content-1',
                'attributes' => [
                    'field_text' => [
                        'processed' => '<p>Komm nach Repelen: Hier wird Trödeln jedes Mal zum Erlebnis.</p>',
                    ],
                ],
            ],
        ]), 200, moersJsonApiHeaders()),
        $typeHref => Http::response(moersJsonApiDocument([
            [
                'type' => 'taxonomy_term--type_of_events',
                'id' => 'type-1',
                'attributes' => [
                    'name' => 'Maerkte',
                ],
            ],
        ]), 200, moersJsonApiHeaders()),
        'https://moers.de/veranstaltungen/troedelmarkt-repelen-6' => Http::response(
            '<html><body><main><h1>Trödelmarkt Repelen</h1><p>Event details</p></main></body></html>',
            200,
        ),
    ]);

    (new LoadMoersEvent($eventHref))->handle();

    $event = Event::query()->firstOrFail();

    expect($event->name)->toBe('Trödelmarkt Repelen')
        ->and($event->description)->toBe('Komm nach Repelen: Hier wird Trödeln jedes Mal zum Erlebnis.')
        ->and($event->category)->toBe('Maerkte')
        ->and($event->extras->get('location'))->toBe('Markt 1-3, 47445 Moers')
        ->and($event->extras->get('street'))->toBe('Markt 1-3')
        ->and($event->extras->get('postcode'))->toBe('47445')
        ->and($event->extras->get('place'))->toBe('Moers')
        ->and($event->extras->get('latitude'))->toBe(51.489071)
        ->and($event->extras->get('longitude'))->toBe(6.601121)
        ->and($event->extras->get('organizer'))->toBe('WMV Märkte & Mehr UG')
        ->and($event->extras->get('organizer_street'))->toBe('Hooghe Weg 2')
        ->and($event->extras->get('organizer_postcode'))->toBe('47906')
        ->and($event->extras->get('organizer_place'))->toBe('Kempen')
        ->and($event->extras->get('organizer_phone'))->toBe('0 21 52 / 15 91')
        ->and($event->extras->get('organizer_email'))->toBe('wmv@example.test')
        ->and($event->extras->get('organizer_website'))->toBe('https://example.test');

    getJson('/api/v1/events/'.$event->id)
        ->assertSuccessful()
        ->assertJsonPath('locationName', 'Markt 1-3, 47445 Moers')
        ->assertJsonPath('street', 'Markt 1-3')
        ->assertJsonPath('postcode', '47445')
        ->assertJsonPath('city', 'Moers')
        ->assertJsonPath('latitude', 51.489071)
        ->assertJsonPath('longitude', 6.601121)
        ->assertJsonPath('organisationName', 'WMV Märkte & Mehr UG')
        ->assertJsonPath('organizerStreet', 'Hooghe Weg 2')
        ->assertJsonPath('organizerPostcode', '47906')
        ->assertJsonPath('organizerCity', 'Kempen');
});

it('keeps existing structured Moers event data when related resources fail', function () {
    $eventHref = 'https://www.moers.de/jsonapi/node/event/event-1?resourceVersion=id%3A1';
    $venueHref = 'https://www.moers.de/jsonapi/node/event/event-1/field_evt_media_venue_ref?resourceVersion=id%3A1';
    $organizerHref = 'https://www.moers.de/jsonapi/node/event/event-1/field_evt_media_organizer_ref?resourceVersion=id%3A1';
    $organizerAddressHref = 'https://www.moers.de/jsonapi/media/company/organizer-1/field_msf_address_ref?resourceVersion=id%3A2';
    $contentHref = 'https://www.moers.de/jsonapi/node/event/event-1/field_nsf_content_ref?resourceVersion=id%3A1';
    $typeHref = 'https://www.moers.de/jsonapi/node/event/event-1/field_evt_type_ref?resourceVersion=id%3A1';

    Http::preventStrayRequests();
    Http::fake([
        $eventHref => Http::response(moersJsonApiDocument(moersEventResource([
            'relationships' => [
                'field_evt_media_venue_ref' => moersRelationship($venueHref),
                'field_evt_media_organizer_ref' => moersRelationship($organizerHref),
                'field_nsf_content_ref' => moersRelationship($contentHref, true),
                'field_evt_type_ref' => moersRelationship($typeHref, true),
            ],
        ])), 200, moersJsonApiHeaders()),
        $venueHref => Http::response(moersJsonApiDocument(moersAddressResource([
            'id' => 'venue-1',
            'name' => 'Markt 1-3, 47445 Moers',
            'field_add_address' => [
                'street' => 'Markt',
                'houseNumber' => '1',
                'houseNumberAddition' => '-3',
                'zip' => '47445',
                'city' => 'Moers',
            ],
            'field_add_geo' => [
                'lat' => 51.489071,
                'lon' => 6.601121,
            ],
        ])), 200, moersJsonApiHeaders()),
        $organizerHref => Http::response(moersJsonApiDocument(moersCompanyResource([
            'id' => 'organizer-1',
            'name' => 'WMV Märkte & Mehr UG',
            'field_com_company' => 'WMV Märkte & Mehr UG',
            'field_msf_email' => 'wmv@example.test',
            'field_msf_homepage' => ['uri' => 'https://example.test'],
            'field_msf_phone' => '0 21 52 / 15 91',
            'relationships' => [
                'field_msf_address_ref' => moersRelationship($organizerAddressHref),
            ],
        ])), 200, moersJsonApiHeaders()),
        $organizerAddressHref => Http::response(moersJsonApiDocument(moersAddressResource([
            'id' => 'organizer-address-1',
            'name' => 'Hooghe Weg 2, 47906 Kempen',
            'field_add_address' => [
                'street' => 'Hooghe Weg',
                'houseNumber' => '2',
                'zip' => '47906',
                'city' => 'Kempen',
            ],
        ])), 200, moersJsonApiHeaders()),
        $contentHref => Http::response(moersJsonApiDocument([
            [
                'type' => 'paragraph--text',
                'id' => 'content-1',
                'attributes' => [
                    'field_text' => [
                        'processed' => '<p>Komm nach Repelen: Hier wird Trödeln jedes Mal zum Erlebnis.</p>',
                    ],
                ],
            ],
        ]), 200, moersJsonApiHeaders()),
        $typeHref => Http::response(moersJsonApiDocument([
            [
                'type' => 'taxonomy_term--type_of_events',
                'id' => 'type-1',
                'attributes' => [
                    'name' => 'Maerkte',
                ],
            ],
        ]), 200, moersJsonApiHeaders()),
        'https://moers.de/veranstaltungen/troedelmarkt-repelen-6' => Http::response(
            '<html><body><main><h1>Trödelmarkt Repelen</h1><p>Event details</p></main></body></html>',
            200,
        ),
    ]);

    (new LoadMoersEvent($eventHref))->handle();

    $event = Event::query()->sole();

    $event->extras = $event->extras->merge(['custom' => 'bleibt']);
    $event->save();

    Http::fake([
        $eventHref => Http::response(moersJsonApiDocument(moersEventResource([
            'relationships' => [
                'field_evt_media_venue_ref' => moersRelationship($venueHref),
                'field_evt_media_organizer_ref' => moersRelationship($organizerHref),
                'field_evt_type_ref' => moersRelationship($typeHref, true),
            ],
        ])), 200, moersJsonApiHeaders()),
        $venueHref => Http::response([], 503, moersJsonApiHeaders()),
        $organizerHref => Http::response([], 503, moersJsonApiHeaders()),
        $typeHref => Http::response([], 503, moersJsonApiHeaders()),
        'https://moers.de/veranstaltungen/troedelmarkt-repelen-6' => Http::response(
            '<html><body><main><h1>Trödelmarkt Repelen</h1><p>Event details</p></main></body></html>',
            200,
        ),
    ]);

    (new LoadMoersEvent($eventHref))->handle();

    $event->refresh();

    expect(Event::query()->count())->toBe(1)
        ->and($event->category)->toBe('Maerkte')
        ->and($event->extras->get('location'))->toBe('Markt 1-3, 47445 Moers')
        ->and($event->extras->get('street'))->toBe('Markt 1-3')
        ->and($event->extras->get('postcode'))->toBe('47445')
        ->and($event->extras->get('place'))->toBe('Moers')
        ->and($event->extras->get('latitude'))->toBe(51.489071)
        ->and($event->extras->get('longitude'))->toBe(6.601121)
        ->and($event->extras->get('organizer'))->toBe('WMV Märkte & Mehr UG')
        ->and($event->extras->get('organizer_street'))->toBe('Hooghe Weg 2')
        ->and($event->extras->get('organizer_postcode'))->toBe('47906')
        ->and($event->extras->get('organizer_place'))->toBe('Kempen')
        ->and($event->extras->get('organizer_phone'))->toBe('0 21 52 / 15 91')
        ->and($event->extras->get('organizer_email'))->toBe('wmv@example.test')
        ->and($event->extras->get('organizer_website'))->toBe('https://example.test')
        ->and($event->extras->get('custom'))->toBe('bleibt')
        ->and($event->extras->get('attendance_mode'))->toBe(Event::ATTENDANCE_OFFLINE)
        ->and($event->extras->get('teaser'))->toBe('Der Trödelmarkt in Repelen - jedes Mal ein schönes Erlebnis!');
});

function moersJsonApiHeaders(): array
{
    return ['Content-Type' => 'application/vnd.api+json'];
}

function moersJsonApiDocument(array $data): array
{
    return [
        'jsonapi' => ['version' => '1.0'],
        'data' => $data,
    ];
}

function moersRelationship(string $href, bool $multiple = false): array
{
    return [
        'data' => $multiple ? [] : null,
        'links' => [
            'related' => ['href' => $href],
        ],
    ];
}

function moersEventResource(array $overrides = []): array
{
    $resource = array_replace_recursive([
        'type' => 'node--event',
        'id' => 'event-1',
        'links' => [
            'self' => [
                'href' => 'https://www.moers.de/jsonapi/node/event/event-1?resourceVersion=id%3A1',
            ],
        ],
        'attributes' => [
            'title' => 'Trödelmarkt Repelen',
            'created' => '2025-08-20T08:11:34+00:00',
            'changed' => '2025-08-20T08:12:02+00:00',
            'path' => ['alias' => '/veranstaltungen/troedelmarkt-repelen-6'],
            'field_evt_date' => [
                'value' => '2026-06-28T11:00:00+02:00',
                'end_value' => '2026-06-28T18:00:00+02:00',
            ],
            'field_nsf_teaser_text' => 'Der Trödelmarkt in Repelen - jedes Mal ein schönes Erlebnis!',
            'field_venue_alt' => null,
        ],
        'relationships' => [],
    ], $overrides);

    if ($resource['relationships'] === []) {
        unset($resource['relationships']);
    }

    return $resource;
}

function moersAddressResource(array $attributes): array
{
    $id = $attributes['id'];
    unset($attributes['id']);

    $resource = [
        'type' => 'media--address',
        'id' => $id,
        'attributes' => $attributes,
        'relationships' => [],
    ];

    unset($resource['relationships']);

    return $resource;
}

function moersCompanyResource(array $attributes): array
{
    $id = $attributes['id'];
    $relationships = $attributes['relationships'] ?? [];
    unset($attributes['id'], $attributes['relationships']);

    $resource = [
        'type' => 'media--company',
        'id' => $id,
        'attributes' => $attributes,
        'relationships' => $relationships,
    ];

    if ($resource['relationships'] === []) {
        unset($resource['relationships']);
    }

    return $resource;
}
