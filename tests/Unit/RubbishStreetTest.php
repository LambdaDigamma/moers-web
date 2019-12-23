<?php

namespace Tests\Unit;

use App\RubbishStreet;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RubbishStreetTest extends TestCase
{

    use RefreshDatabase;

    public function testRubbishStreetFactory()
    {

        $rubbishStreet = factory(RubbishStreet::class)->create();

        $this->assertNotNull($rubbishStreet->id);
        $this->assertNotNull($rubbishStreet->name);
        $this->assertNull($rubbishStreet->street_addition);
        $this->assertNotNull($rubbishStreet->residual_tour);
        $this->assertNotNull($rubbishStreet->organic_tour);
        $this->assertNotNull($rubbishStreet->paper_tour);
        $this->assertNotNull($rubbishStreet->yellow_bag_tour);
        $this->assertNotNull($rubbishStreet->green_cut_tour);
        $this->assertNotNull($rubbishStreet->year);

    }

    public function testRubbishStreetCurrentScope()
    {

        $rubbishStreet1 = factory(RubbishStreet::class)->create();
        $rubbishStreet2 = factory(RubbishStreet::class)->create(['year' => Carbon::now()->subYear()->year]);

        $currentStreets = RubbishStreet::current()->get();

        $this->assertCount(1, $currentStreets);

    }

}
