<?php

namespace Modules\Waste\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Waste\Models\RubbishStreet;

class RubbishStreetFactory extends Factory
{
    protected $model = RubbishStreet::class;

    public function definition(): array
    {
        return [
            'name' => fake()->streetName,
            'street_addition' => null,
            'residual_tour' => fake()->numberBetween(1, 10),
            'organic_tour' => fake()->numberBetween(1, 10),
            'paper_tour' => fake()->numberBetween(1, 10),
            'plastic_tour' => fake()->numberBetween(1, 10),
            'cuttings_tour' => fake()->numberBetween(1, 10),
            'year' => Carbon::now()->year
        ];
    }

    public function old(): RubbishStreetFactory
    {
        return $this->state([
            'year' => Carbon::now()->subYears(fake()->numberBetween(1, 10))->year
        ]);
    }
}
