<?php

namespace Modules\Parking\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Parking\Models\ParkingArea;

class ParkingAreaController extends Controller
{
    public function index(): JsonResponse
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

    public function show(ParkingArea $parkingArea): JsonResponse
    {

        $pastOccupancy = Cache::remember('api_past_occupancy_parking_area_' . $parkingArea->id, 1, function () use ($parkingArea) {
            $driver = config('database.default');

            if ($driver === 'pgsql') {
                $data = DB::table('parking_area_occupancies')
                    ->selectRaw('AVG(occupancy_rate) AS occupancy_rate, EXTRACT(HOUR FROM created_at) AS hour')
                    ->where('parking_area_id', $parkingArea->id)
                    ->whereRaw('created_at >= NOW() - INTERVAL \'23 hours\'')
                    ->groupBy('hour')
                    ->orderBy('hour')
                    ->get();
            } else {
                $data = DB::table('parking_area_occupancies')
                    ->selectRaw('avg(occupancy_rate) as occupancy_rate, HOUR(created_at) as hour')
                    ->where('parking_area_id', $parkingArea->id)
                    ->whereRaw('created_at >= NOW() - INTERVAL 23 HOUR')
                    ->groupBy('hour')
                    ->orderBy('created_at')
                    ->get();
            }

            return [
                // 'max_capacity' => 10,
                'data' => $data,
            ];
        });

        return new JsonResponse([
            'data' => [
                'parking_area' => $parkingArea,
                'past_occupancy' => [
                    'max_capacity' => 10,
                    'data' => $pastOccupancy
                ]
            ]
        ], Response::HTTP_OK);
    }
}
