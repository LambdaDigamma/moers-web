<?php

use App\Models\ParkingArea;

it('test get parking lots', function () {

    $response = $this->get('/api/v1/parking-areas');

    // $response->assertStatus(200);
    dd(ParkingArea::all());

});