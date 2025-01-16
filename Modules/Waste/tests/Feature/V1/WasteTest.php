<?php

use Illuminate\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Waste\Models\RubbishScheduleItem;
use Modules\Waste\Models\RubbishStreet;

use function Pest\Laravel\travelTo;

test('get rubbish street pickup list', function () {

    travelTo(Carbon::parse('2022-01-01'));

    $rubbishStreet = RubbishStreet::factory()->create([
        'name' => 'Musterstraße',
        'residual_tour' => 1,
        'organic_tour' => 1,
        'paper_tour' => 6,
        'plastic_tour' => 4,
        'cuttings_tour' => 0,
    ]);

    $pickupItem = RubbishScheduleItem::create([
        'date' => '2022-01-03',
        'residual_tours' => '6',
        'organic_tours' => '6',
        'paper_tours' => '1',
        'plastic_tours' => '4,6',
        'cuttings_tours' => '',
    ]);

    $this->get("/api/v1/rubbish/streets/{$rubbishStreet->id}/pickups")
        ->assertStatus(200)
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->has(
                    'data',
                    fn (AssertableJson $json) => $json->has(1)
                        ->first(
                            fn ($json) => $json
                                ->where('date', '2022-01-03')
                                ->where('type', 'plastic')
                        )
                )
        );

});
