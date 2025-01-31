<?php

namespace Modules\Rubbish\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Rubbish\Models\RubbishScheduleItem;

class RubbishScheduleItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RubbishScheduleItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => Carbon::now()->addDays($this->faker->numberBetween(0, 20))->toDateString(),
            'residual_tours' => $this->faker->numberBetween(1, 10),
            'organic_tours' => $this->faker->numberBetween(1, 10),
            'paper_tours' => $this->faker->numberBetween(1, 10),
            'plastic_tours' => $this->faker->numberBetween(1, 10),
            'cuttings_tours' => $this->faker->numberBetween(1, 10),
        ];
    }
}
