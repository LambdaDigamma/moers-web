<?php

namespace Database\Factories;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParkingAreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->streetName(),
        ];
    }

    // does not work at the moment
    public function withLocation() 
    {
        return $this->state(function (array $attributes) {
            return [
                'location' => new Point($this->faker->latitude, $this->faker->longitude),
            ];
        });
    }
}
