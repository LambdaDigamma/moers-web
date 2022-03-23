<?php

namespace Database\Factories;

use App\Models\ParkingArea;
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
        $name = $this->faker->streetName();
        return [
            'name' => $name,
            'slug' => ParkingArea::createSlug($name),
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
