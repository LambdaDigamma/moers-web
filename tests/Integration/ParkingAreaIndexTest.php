<?php

it('test get parking lots', function () {

    $response = $this->get('/api/v1/parking-areas');

    $response
        ->assertOk();

    // $response->assertStatus(200);
    // dd(ParkingArea::all());

});
