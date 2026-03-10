<?php

namespace Modules\Parking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Parking\Models\ParkingAreaOccupancy;

class ParkingAreaOccupancyFactory extends Factory
{
    protected $model = ParkingAreaOccupancy::class;

    public function definition(): array
    {
        $capacity = fake()->numberBetween(50, 500);
        $occupied = fake()->numberBetween(0, $capacity);

        return [
            'occupancy_rate' => $occupied / $capacity,
            'occupied_sites' => $occupied,
            'capacity' => $capacity,
            'opening_state' => 'open',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
