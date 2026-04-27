<?php

use Modules\Events\Enums\ScheduleDisplay;
use Modules\Events\Integrations\MoersFestival\Requests\GetEventsRequest;
use Modules\Events\Models\Event;
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
