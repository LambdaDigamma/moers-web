<?php

namespace Tests\Feature;

use App\RubbishScheduleItem;
use App\RubbishStreet;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RubbishAPITest extends TestCase
{

    use RefreshDatabase;

    public function testStreetListCurrentStreets()
    {

        $streets = factory(RubbishStreet::class, 10)->create();

        $this->get('/api/v2/rubbish/streets')
             ->assertStatus(200)
             ->assertJson($streets->toArray());

    }

    public function testStreetListOldAndNewStreets()
    {

        $currentStreets = factory(RubbishStreet::class, 10)->create();
        factory(RubbishStreet::class, 10)->state('old')->create();

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

        $rubbishStreet = factory(RubbishStreet::class)->create([
            'residual_tour' => $residual,
            'organic_tour' => $organic,
            'paper_tour' => $paper,
            'plastic_tour' => $plastic,
            'cuttings_tour' => $cuttings,
        ]);
        factory(RubbishScheduleItem::class)->create([
            'residual_tours' => 10,
            'organic_tours' => 11,
            'paper_tours' => 12,
            'plastic_tours' => 13,
            'cuttings_tours' => 14,
        ]);
        factory(RubbishScheduleItem::class)->create([
            'residual_tours' => $residual,
            'organic_tours' => 21,
            'paper_tours' => 22,
            'plastic_tours' => 23,
            'cuttings_tours' => 24,
        ]);
        factory(RubbishScheduleItem::class)->create([
            'residual_tours' => 31,
            'organic_tours' => $organic,
            'paper_tours' => 32,
            'plastic_tours' => 33,
            'cuttings_tours' => 34,
        ]);
        factory(RubbishScheduleItem::class)->create([
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