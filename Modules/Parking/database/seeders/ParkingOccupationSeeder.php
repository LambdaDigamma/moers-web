<?php

namespace Modules\Parking\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Parking\Models\ParkingArea;
use Modules\Parking\Models\ParkingAreaOccupancy;

class ParkingOccupationSeeder extends Seeder
{
    public function run(): void
    {
        $parkingAreas = ParkingArea::all();
        $now = Carbon::now()->startOfHour();

        foreach ($parkingAreas as $area) {
            for ($i = 0; $i < 24; $i++) {
                $time = $now->copy()->subHours($i);

                // Add some randomness to the occupancy
                $capacity = $area->capacity ?? 200;
                $occupied = rand(0, $capacity);

                ParkingAreaOccupancy::factory()->create([
                    'parking_area_id' => $area->id,
                    'capacity' => $capacity,
                    'occupied_sites' => $occupied,
                    'occupancy_rate' => $occupied / ($capacity ?: 1),
                    'created_at' => $time,
                    'updated_at' => $time,
                ]);
            }
        }
    }
}
