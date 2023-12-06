<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ParkingArea;

use function Pest\Laravel\getJson;

class ParkingAreaDashboardController extends Controller
{
    public function __invoke()
    {
        $parkingAreas = ParkingArea::query()
            ->open()
            ->get();

        return [
            'data' => [
                'parking_areas' => $parkingAreas
            ],
        ];
    }
}