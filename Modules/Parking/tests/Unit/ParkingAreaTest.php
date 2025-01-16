<?php

use Modules\Parking\Models\ParkingArea;

it('creating slug for parking area works', function () {
    
    expect(ParkingArea::createSlug('Kautzstr.'))
        ->toBe('kautzstr');

    expect(ParkingArea::createSlug('Bahnhof'))
        ->toBe('bahnhof');

    expect(ParkingArea::createSlug('Kautzstr. (Parkplatz)'))
        ->toBe('kautzstr-parkplatz');

    expect(ParkingArea::createSlug('Neuer Wall'))
        ->toBe('neuer-wall');

});

test('open and closed parking areas can be scoped', function () {

    $closed = ParkingArea::factory()
        ->closed()
        ->count(4)
        ->create();

    $open = ParkingArea::factory()
        ->open()
        ->count(5)
        ->create();

    expect(ParkingArea::query()->open()->get()->count())->toBe(5);
    expect(ParkingArea::query()->closed()->get()->count())->toBe(4);

});
