<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Rubbish\Models\RubbishStreet;

class RubbishStreetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RubbishStreet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->streetName,
            'street_addition' => null,
            'residual_tour' => $this->faker->numberBetween(1, 10),
            'organic_tour' => $this->faker->numberBetween(1, 10),
            'paper_tour' => $this->faker->numberBetween(1, 10),
            'plastic_tour' => $this->faker->numberBetween(1, 10),
            'cuttings_tour' => $this->faker->numberBetween(1, 10),
            'year' => Carbon::now()->year
        ];
    }

    public function old()
    {
        return $this->state([
            'year' => Carbon::now()->subYears($this->faker->numberBetween(1, 10))->year
        ]);
    }
}
