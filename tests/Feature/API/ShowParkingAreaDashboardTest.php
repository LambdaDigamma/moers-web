<?php

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Parking\Models\ParkingArea;
use function Pest\Laravel\getJson;

it('show parking area dashboard', function () {

    ParkingArea::factory()->closed()->create();
    $parkingArea1 = ParkingArea::factory()->open()->create();
    ParkingArea::factory()->open()->count(4)->create();

    getJson('/api/v1/parking/dashboard')
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) =>
            $json
                ->has('data.parking_areas', 5)
                ->has('data.parking_areas.0', fn ($json) =>
                    $json->where('id', $parkingArea1->id)
                        ->where('current_opening_state', 'open')
                        ->etc()
                )
        );
        
});
