<?php

namespace Modules\Parking\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Parking\Models\ParkingArea;

class ParkingAreaDashboardController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $parkingAreas = ParkingArea::query()
            ->open()
            ->get();

        return new JsonResponse([
            'data' => [
                'parking_areas' => $parkingAreas,
            ],
        ]);
    }
}
