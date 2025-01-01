<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Modules\Rubbish\Models\RubbishScheduleItem;
use Modules\Rubbish\Models\RubbishStreet;
use Tests\TestCase;

class RubbishAPITest extends TestCase
{

    public function testStreetListCurrentStreets()
    {

        $streets = RubbishStreet::factory(10)->create();

        $this->get('/api/v2/rubbish/streets')
             ->assertStatus(200)
             ->assertJson($streets->toArray());

    }

    public function testStreetListOldAndNewStreets()
    {

        $currentStreets = RubbishStreet::factory(10)->create();
        RubbishStreet::factory(10)->old()->create();

        $this->get('/api/v2/rubbish/streets')
             ->assertStatus(200)
             ->assertJson($currentStreets->toArray());

    }

    public function testStreetPickups()
    {

        $residual = 1;
        $organic = 2;
        $paper = 3;
        $plastic = 4;
        $cuttings = 5;

        $rubbishStreet = RubbishStreet::factory()->create([
            'residual_tour' => $residual,
            'organic_tour' => $organic,
            'paper_tour' => $paper,
            'plastic_tour' => $plastic,
            'cuttings_tour' => $cuttings,
        ]);
        RubbishScheduleItem::factory()->create([
            'residual_tours' => 10,
            'organic_tours' => 11,
            'paper_tours' => 12,
            'plastic_tours' => 13,
            'cuttings_tours' => 14,
        ]);
        RubbishScheduleItem::factory()->create([
            'residual_tours' => $residual,
            'organic_tours' => 21,
            'paper_tours' => 22,
            'plastic_tours' => 23,
            'cuttings_tours' => 24,
        ]);
        RubbishScheduleItem::factory()->create([
            'residual_tours' => 31,
            'organic_tours' => $organic,
            'paper_tours' => 32,
            'plastic_tours' => 33,
            'cuttings_tours' => 34,
        ]);
        RubbishScheduleItem::factory()->create([
            'residual_tours' => 41,
            'organic_tours' => 42,
            'paper_tours' => $paper,
            'plastic_tours' => 43,
            'cuttings_tours' => 44,
            'date' => Carbon::yesterday()->toDateString()
        ]);

        $this->get('/api/v2/rubbish/streets/' . $rubbishStreet->id . '/pickups')
             ->assertStatus(200)
             ->assertJson($rubbishStreet->pickupItems()->toArray());

    }

}
