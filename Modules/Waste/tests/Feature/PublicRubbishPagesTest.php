<?php

use Illuminate\Support\Carbon;
use Inertia\Testing\AssertableInertia as Assert;
use Modules\Waste\Models\RubbishScheduleItem;
use Modules\Waste\Models\RubbishStreet;

use function Pest\Laravel\get;
use function Pest\Laravel\travelTo;

it('shows the public rubbish search page', function () {
    RubbishStreet::factory()->create(['name' => 'Musterstraße']);
    RubbishStreet::factory()->old()->create(['name' => 'Alte Straße']);

    get('/abfallkalender?q=Muster')
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('rubbish/index')
            ->where('filters.q', 'Muster')
            ->has('streets', 1)
            ->where('streets.0.name', 'Musterstraße'));
});

it('finds streets when umlauts are typed as ascii variants', function () {
    RubbishStreet::factory()->create(['name' => 'Goethestraße']);

    get('/abfallkalender?q=Goethestrasse')
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('rubbish/index')
            ->where('filters.q', 'Goethestrasse')
            ->has('streets', 1)
            ->where('streets.0.name', 'Goethestraße'));
});

it('shows the public rubbish detail page', function () {
    travelTo(Carbon::parse('2026-01-01'));

    $street = RubbishStreet::factory()->create([
        'name' => 'Ackerweg',
        'residual_tour' => 1,
        'organic_tour' => 1,
        'paper_tour' => 6,
        'plastic_tour' => 4,
        'cuttings_tour' => 0,
    ]);

    RubbishScheduleItem::create([
        'date' => '2026-01-03',
        'residual_tours' => '6',
        'organic_tours' => '6',
        'paper_tours' => '1',
        'plastic_tours' => '4,6',
        'cuttings_tours' => '',
    ]);

    get("/abfallkalender/{$street->id}")
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('rubbish/show')
            ->where('street.name', 'Ackerweg')
            ->has('pickupGroups', 1)
            ->where('pickupGroups.0.date', '2026-01-03')
            ->has('pickupGroups.0.items', 1)
            ->where('pickupGroups.0.items.0.type', 'plastic')
            ->where('downloads.pdf_download_url', 'https://abfallkalender.enni.de/pdf-kalender/ackerweg')
            ->where('downloads.pdf_view_url', 'https://abfallkalender.enni.de/assets/addons/pdfout/vendor/web/viewer.html?file=%2Fpdf-kalender%2Fackerweg')
            ->where('downloads.full_pdf_url', 'https://abfallkalender.enni.de/media/abfallkalender_2026.pdf')
            ->where('downloads.ics_download_url', 'https://abfallkalender.enni.de/ics-kalender/ackerweg')
            ->where('downloads.apple_calendar_url', 'webcal://abfallkalender.enni.de/ics-kalender/ackerweg')
            ->where('downloads.google_calendar_url', 'https://calendar.google.com/calendar/r?cid=webcal://abfallkalender.enni.de/ics-kalender/ackerweg')
            ->where('downloads.outlook_calendar_url', 'https://outlook.office.com/calendar/0/addfromweb?url=https://abfallkalender.enni.de/ics-kalender/ackerweg'));
});
