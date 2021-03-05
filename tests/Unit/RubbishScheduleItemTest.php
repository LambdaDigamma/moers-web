<?php

namespace Tests\Unit;

use App\Models\RubbishScheduleItem;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RubbishScheduleItemTest extends TestCase
{

    use RefreshDatabase;

    public function testRubbishScheduleItemFactory()
    {

        $item = RubbishScheduleItem::factory()->create();

        $this->assertNotNull($item->id);
        $this->assertNotNull($item->date);
        $this->assertNotNull($item->residual_tours);
        $this->assertNotNull($item->organic_tours);
        $this->assertNotNull($item->paper_tours);
        $this->assertNotNull($item->plastic_tours);
        $this->assertNotNull($item->cuttings_tours);

    }

    public function testRubbishScheduleItemRouteAccessorsAndMutators()
    {

        $item = RubbishScheduleItem::factory()
            ->create(
                [
                    'residual_tours' => [2,5],
                    'organic_tours' => [1,2],
                    'paper_tours' => [6,9],
                    'plastic_tours' => [3,4],
                    'cuttings_tours' => [8, 7]
                ]
            );

        $item2 = RubbishScheduleItem::factory()
            ->create(
                [
                    'residual_tours' => 2,
                ]
            );

        $this->assertTrue($item->residual_tours == collect([2, 5]));
        $this->assertTrue($item->organic_tours == collect([1, 2]));
        $this->assertTrue($item->paper_tours == collect([6, 9]));
        $this->assertTrue($item->plastic_tours == collect([3, 4]));
        $this->assertTrue($item->cuttings_tours == collect([8, 7]));

        $this->assertTrue($item2->residual_tours == collect([2]));

    }

    public function testRubbishScheduleItemUpcomingScope()
    {

        $item1 = RubbishScheduleItem::factory()->create(['date' => Carbon::today()->toDateString()]);
        $item2 = RubbishScheduleItem::factory()->create(['date' => Carbon::yesterday()->toDateString()]);
        $item3 = RubbishScheduleItem::factory()->create(['date' => Carbon::tomorrow()->toDateString()]);

        $items = RubbishScheduleItem::upcoming()->get();

        $this->assertCount(2, $items);
        $this->assertTrue($items->contains($item1));
        $this->assertTrue($items->contains($item3));
    }

}
