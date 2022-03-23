<?php

use App\Models\ParkingArea;

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