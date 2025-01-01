<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Modules\Rubbish\Models\RubbishScheduleItem;
use Modules\Rubbish\Models\RubbishStreet;
use Tests\TestCase;

class RubbishStreetTest extends TestCase
{

    public function testRubbishStreetFactory()
    {

        $rubbishStreet = RubbishStreet::factory()->create();

        $this->assertNotNull($rubbishStreet->id);
        $this->assertNotNull($rubbishStreet->name);
        $this->assertNull($rubbishStreet->street_addition);
        $this->assertNotNull($rubbishStreet->residual_tour);
        $this->assertNotNull($rubbishStreet->organic_tour);
        $this->assertNotNull($rubbishStreet->paper_tour);
        $this->assertNotNull($rubbishStreet->plastic_tour);
        $this->assertNotNull($rubbishStreet->cuttings_tour);
        $this->assertNotNull($rubbishStreet->year);

    }

    public function testRubbishStreetCurrentScope()
    {

        $rubbishStreet1 = RubbishStreet::factory()->create();
        $rubbishStreet2 = RubbishStreet::factory()->create(['year' => Carbon::now()->subYear()->year]);

        $currentStreets = RubbishStreet::current()->get();

        $this->assertCount(1, $currentStreets);

    }

    public function testScheduleItemsForStreet()
    {

        $residual = 1;
        $organic = 2;
        $paper = 3;
        $plastic = 4;
        $cuttings = 5;

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
            'organic_tours' => [$organic, 35],
            'paper_tours' => 32,
            'plastic_tours' => 33,
            'cuttings_tours' => 34,
        ]);
        $rubbishStreet = RubbishStreet::factory()->create([
            'residual_tour' => $residual,
            'organic_tour' => $organic,
            'paper_tour' => $paper,
            'plastic_tour' => $plastic,
            'cuttings_tour' => $cuttings,
        ]);

        $this->assertCount(2, $rubbishStreet->pickupItems());

    }

}
