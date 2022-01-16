<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ParkingArea;
use Cache;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ParkingAreaController extends Controller
{
    public function index()
    {
        $parkingAreas = Cache::remember('api_parking_areas_index', 30, function () {
            return ParkingArea::query()
                    ->orderByOpeningState()
                    ->get();
        });

        return new JsonResponse([
            'data' => [
                'parking_areas' => $parkingAreas,
            ]
        ], Response::HTTP_OK);
    }
}