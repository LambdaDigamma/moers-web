<?php

namespace Database\Factories;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Parking\Models\ParkingArea;

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

    public function open() 
    {
        return $this->state(function (array $attributes) {
            return [
                'current_opening_state' => ParkingArea::OPEN,
            ];
        });
    }

    public function closed() 
    {
        return $this->state(function (array $attributes) {
            return [
                'current_opening_state' => ParkingArea::CLOSED,
            ];
        });
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
