<?php

use Modules\Parking\Models\ParkingArea;

test('api show parking area', function () {

    $parkingArea = ParkingArea::factory()->create();

    $this->get('/api/v1/parking-areas/'.$parkingArea->id)
        ->assertOk();

});
