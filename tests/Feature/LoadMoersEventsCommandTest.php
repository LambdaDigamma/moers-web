<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Modules\Events\Jobs\LoadMoersEvent;
use Modules\Events\Models\Event;
use Modules\Management\Actions\ResolveImportedOrganisation;
use Modules\Management\Models\Organisation;
use Tests\Fakes\FakeMediaDownloader;

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
    $organisation = Organisation::query()->sole();

    expect($event->name)->toBe('Trödelmarkt Repelen')
        ->and($event->organisation_id)->toBe($organisation->id)
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

    expect($organisation->name)->toBe('WMV Märkte & Mehr UG')
        ->and($organisation->slug)->toBe('wmv-markte-mehr-ug')
        ->and($organisation->external_source)->toBe('moers:media.company')
        ->and($organisation->external_id)->toBe('organizer-1')
        ->and($organisation->external_url)->toBe('https://www.moers.de/jsonapi/media/company/organizer-1?resourceVersion=id%3A2')
        ->and($organisation->email)->toBe('wmv@example.test')
        ->and($organisation->phone)->toBe('0 21 52 / 15 91')
        ->and($organisation->website_url)->toBe('https://example.test')
        ->and($organisation->street)->toBe('Hooghe Weg 2')
        ->and($organisation->postcode)->toBe('47906')
        ->and($organisation->city)->toBe('Kempen');

    getJson('/api/v1/events/'.$event->id)
        ->assertSuccessful()
        ->assertJsonPath('locationName', 'Markt 1-3, 47445 Moers')
        ->assertJsonPath('street', 'Markt 1-3')
        ->assertJsonPath('postcode', '47445')
        ->assertJsonPath('city', 'Moers')
        ->assertJsonPath('latitude', 51.489071)
        ->assertJsonPath('longitude', 6.601121)
        ->assertJsonPath('organisationName', 'WMV Märkte & Mehr UG')
        ->assertJsonPath('organisationSlug', 'wmv-markte-mehr-ug')
        ->assertJsonPath('organizerStreet', 'Hooghe Weg 2')
        ->assertJsonPath('organizerPostcode', '47906')
        ->assertJsonPath('organizerCity', 'Kempen');
});

it('fuzzy matches Moers organizers to existing organisations before creating new ones', function () {
    $organisation = Organisation::factory()->create([
        'name' => 'Schutzenverein Moers Vinn 1903',
        'slug' => 'schutzenverein-moers-vinn-1903',
        'description' => 'Curated organisation description',
    ]);

    $eventHref = 'https://www.moers.de/jsonapi/node/event/event-1?resourceVersion=id%3A1';
    $organizerHref = 'https://www.moers.de/jsonapi/node/event/event-1/field_evt_media_organizer_ref?resourceVersion=id%3A1';
    $organizerAddressHref = 'https://www.moers.de/jsonapi/media/company/organizer-1/field_msf_address_ref?resourceVersion=id%3A2';

    Http::preventStrayRequests();
    Http::fake([
        $eventHref => Http::response(moersJsonApiDocument(moersEventResource([
            'attributes' => [
                'title' => 'Eulenschießen',
                'path' => ['alias' => '/veranstaltungen/eulenschiessen-0'],
            ],
            'relationships' => [
                'field_evt_media_organizer_ref' => moersRelationship($organizerHref),
            ],
        ])), 200, moersJsonApiHeaders()),
        $organizerHref => Http::response(moersJsonApiDocument(moersCompanyResource([
            'id' => '8592b34d-2dfb-4a3d-a8e8-fd157b9024e0',
            'name' => 'Schützenverein Moers-Vinn 1903 e.V.',
            'field_com_company' => 'Schützenverein Moers-Vinn 1903 e.V.',
            'field_msf_email' => 'info@vinn03.de',
            'field_msf_homepage' => ['uri' => 'http://www.vinn03.de'],
            'field_msf_phone' => '0 28 41 / 3 33 46',
            'relationships' => [
                'field_msf_address_ref' => moersRelationship($organizerAddressHref),
            ],
        ])), 200, moersJsonApiHeaders()),
        $organizerAddressHref => Http::response(moersJsonApiDocument(moersAddressResource([
            'id' => 'organizer-address-1',
            'name' => 'Vinner Straße 63, 47447 Moers',
            'field_add_address' => [
                'street' => 'Vinner Straße',
                'houseNumber' => '63',
                'zip' => '47447',
                'city' => 'Moers',
            ],
        ])), 200, moersJsonApiHeaders()),
        'https://moers.de/veranstaltungen/eulenschiessen-0' => Http::response(
            '<html><body><main><h1>Eulenschießen</h1><p>Event details</p></main></body></html>',
            200,
        ),
    ]);

    (new LoadMoersEvent($eventHref))->handle();

    $event = Event::query()->sole();
    $organisation->refresh();

    expect(Organisation::query()->count())->toBe(1)
        ->and($event->organisation_id)->toBe($organisation->id)
        ->and($organisation->description)->toBe('Curated organisation description')
        ->and($organisation->external_source)->toBe('moers:media.company')
        ->and($organisation->external_id)->toBe('8592b34d-2dfb-4a3d-a8e8-fd157b9024e0')
        ->and($organisation->email)->toBe('info@vinn03.de')
        ->and($organisation->phone)->toBe('0 28 41 / 3 33 46')
        ->and($organisation->website_url)->toBe('http://www.vinn03.de')
        ->and($organisation->street)->toBe('Vinner Straße 63')
        ->and($organisation->postcode)->toBe('47447')
        ->and($organisation->city)->toBe('Moers');
});

it('refreshes non-null fields for externally matched organisations without clearing missing upstream fields', function () {
    $organisation = Organisation::factory()->create([
        'name' => 'Stadt Moers',
        'slug' => 'stadt-moers',
        'external_source' => 'moers:media.company',
        'external_id' => 'company-1',
        'external_url' => 'https://www.moers.de/old',
        'email' => 'old@example.test',
        'phone' => '0 28 41 / 201-0',
        'website_url' => 'https://old.example.test',
        'street' => 'Alte Strasse 1',
        'postcode' => '47441',
        'city' => 'Moers',
    ]);

    $resolved = app(ResolveImportedOrganisation::class)->handle(
        name: 'Stadt Moers',
        externalSource: 'moers:media.company',
        externalId: 'company-1',
        externalUrl: 'https://www.moers.de/jsonapi/media/company/company-1?resourceVersion=id%3A2',
        email: null,
        phone: '0 28 41 / 201-1',
        websiteUrl: null,
        street: 'Rathausplatz 1',
        postcode: null,
        city: 'Moers',
    );

    $organisation->refresh();

    expect($resolved->is($organisation))->toBeTrue()
        ->and($organisation->external_url)->toBe('https://www.moers.de/jsonapi/media/company/company-1?resourceVersion=id%3A2')
        ->and($organisation->email)->toBe('old@example.test')
        ->and($organisation->phone)->toBe('0 28 41 / 201-1')
        ->and($organisation->website_url)->toBe('https://old.example.test')
        ->and($organisation->street)->toBe('Rathausplatz 1')
        ->and($organisation->postcode)->toBe('47441')
        ->and($organisation->city)->toBe('Moers');
});

it('uses a text with media content image as header image when the teaser image is missing', function () {
    config(['media-library.media_downloader' => FakeMediaDownloader::class]);
    Storage::fake('media');

    $eventHref = 'https://www.moers.de/jsonapi/node/event/event-1?resourceVersion=id%3A1';
    $teaserHref = 'https://www.moers.de/jsonapi/node/event/event-1/field_nsf_teaser_image_ref?resourceVersion=id%3A1';
    $contentHref = 'https://www.moers.de/jsonapi/node/event/event-1/field_nsf_content_ref?resourceVersion=id%3A1';
    $contentMediaHref = 'https://www.moers.de/jsonapi/paragraph/text_with_media/content-1/field_media_ref?resourceVersion=id%3A2';
    $contentMediaFileHref = 'https://www.moers.de/jsonapi/media/image/media-1/field_media_image?resourceVersion=id%3A3';

    Http::preventStrayRequests();
    Http::fake([
        $eventHref => Http::response(moersJsonApiDocument(moersEventResource([
            'attributes' => [
                'title' => 'Eulenschießen',
                'path' => ['alias' => '/veranstaltungen/eulenschiessen-0'],
                'field_nsf_teaser_text' => 'Traditionelles Eulenschießen.',
            ],
            'relationships' => [
                'field_nsf_teaser_image_ref' => moersRelationship($teaserHref),
                'field_nsf_content_ref' => moersRelationship($contentHref, true),
            ],
        ])), 200, moersJsonApiHeaders()),
        $teaserHref => Http::response(moersJsonApiDocument(null), 200, moersJsonApiHeaders()),
        $contentHref => Http::response(moersJsonApiDocument([
            [
                'type' => 'paragraph--text_with_media',
                'id' => 'content-1',
                'attributes' => [
                    'field_text' => [
                        'processed' => '<p>Unter dem Motto „Wer wird Meistereule 2026?“ treffen sich alle zum Eulenschießen.</p>',
                    ],
                ],
                'relationships' => [
                    'field_media_ref' => moersRelationship($contentMediaHref),
                ],
            ],
        ]), 200, moersJsonApiHeaders()),
        $contentMediaHref => Http::response(moersJsonApiDocument([
            'type' => 'media--image',
            'id' => 'media-1',
            'attributes' => [
                'name' => 'eulenschiessen.jpg',
            ],
            'relationships' => [
                'field_media_image' => [
                    'data' => [
                        'type' => 'file--file',
                        'id' => 'file-1',
                        'meta' => [
                            'alt' => 'Eine Person, die eine Eule aus Holz bemalt.',
                        ],
                    ],
                    'links' => [
                        'related' => ['href' => $contentMediaFileHref],
                    ],
                ],
            ],
        ]), 200, moersJsonApiHeaders()),
        $contentMediaFileHref => Http::response(moersJsonApiDocument([
            'type' => 'file--file',
            'id' => 'file-1',
            'attributes' => [
                'uri' => [
                    'url' => '/sites/default/files/2026-06/eulenschiessen.jpg',
                ],
            ],
        ]), 200, moersJsonApiHeaders()),
        'https://moers.de/veranstaltungen/eulenschiessen-0' => Http::response(
            '<html><body><main><h1>Eulenschießen</h1><p>Event details</p></main></body></html>',
            200,
        ),
    ]);

    (new LoadMoersEvent($eventHref))->handle();

    $event = Event::query()->sole();
    $media = $event->getFirstMedia(Event::HEADER_MEDIA_COLLECTION);

    expect($event->description)->toBe('Unter dem Motto „Wer wird Meistereule 2026?“ treffen sich alle zum Eulenschießen.')
        ->and($media)->not->toBeNull()
        ->and($media->file_name)->toBe('eulenschiessen.jpg')
        ->and($media->getCustomProperty('alt'))->toBe('Eine Person, die eine Eule aus Holz bemalt.');
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
    $organisationId = $event->organisation_id;

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
        ->and(Organisation::query()->count())->toBe(1)
        ->and($event->organisation_id)->toBe($organisationId)
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

function moersJsonApiDocument(mixed $data): array
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
        'links' => [
            'self' => [
                'href' => "https://www.moers.de/jsonapi/media/company/{$id}?resourceVersion=id%3A2",
            ],
        ],
        'attributes' => $attributes,
        'relationships' => $relationships,
    ];

    if ($resource['relationships'] === []) {
        unset($resource['relationships']);
    }

    return $resource;
}
