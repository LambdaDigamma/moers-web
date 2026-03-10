<?php

namespace Modules\Parking\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AppleMapSnapshot;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Modules\Parking\Models\ParkingArea;

class ParkingController extends Controller
{
    public function index(): Response
    {
        $parkingAreas = ParkingArea::query()
            ->orderByOpeningState()
            ->get()
            ->map(fn (ParkingArea $area) => [
                'id' => $area->id,
                'name' => $area->name,
                'slug' => $area->slug,
                'capacity' => $area->capacity,
                'occupied' => $area->occupied_sites,
                'state' => $area->current_opening_state,
            ]);

        return inertia('parking/index', [
            'parkingAreas' => $parkingAreas,
        ]);
    }

    public function show(ParkingArea $parkingArea): Response
    {
        $pastOccupancy = Cache::remember('api_past_occupancy_parking_area_'.$parkingArea->id, 1, function () use ($parkingArea) {
            $driver = config('database.default');

            if ($driver === 'pgsql') {
                return DB::table('parking_area_occupancies')
                    ->selectRaw('AVG(occupancy_rate) AS occupancy_rate, EXTRACT(HOUR FROM created_at) AS hour')
                    ->where('parking_area_id', $parkingArea->id)
                    ->whereRaw('created_at >= NOW() - INTERVAL \'23 hours\'')
                    ->groupBy('hour')
                    ->orderBy('hour')
                    ->get();
            } else {
                return DB::table('parking_area_occupancies')
                    ->selectRaw('avg(occupancy_rate) as occupancy_rate, HOUR(created_at) as hour')
                    ->where('parking_area_id', $parkingArea->id)
                    ->whereRaw('created_at >= NOW() - INTERVAL 23 HOUR')
                    ->groupBy('hour')
                    ->orderBy('created_at')
                    ->get();
            }
        });

        $lat = $parkingArea->location?->getLatitude();
        $lng = $parkingArea->location?->getLongitude();

        $imageUrl = null;
        if ($lat && $lng) {
            $imageUrl = AppleMapSnapshot::signedURL('auto', [
                'z' => '13',
                'lang' => 'de-DE',
                'scale' => 2,
                'poi' => 0,
                'annotations' => [
                    [
                        'point' => "$lat,$lng",
                        'color' => '2563EB',
                        'markerStyle' => 'large',
                        'glyphText' => 'P',
                    ],
                ],
            ]);
        }

        return inertia('parking/show', [
            'parkingArea' => [
                'id' => $parkingArea->id,
                'name' => $parkingArea->name,
                'slug' => $parkingArea->slug,
                'capacity' => $parkingArea->capacity,
                'occupied' => $parkingArea->occupied_sites,
                'state' => $parkingArea->current_opening_state,
                'updated_at' => $parkingArea->updated_at?->toIso8601String(),
            ],
            'pastOccupancy' => $pastOccupancy,
            'imageUrl' => $imageUrl,
            'googleMapsUrl' => $lat && $lng ? "https://www.google.com/maps/dir/?api=1&destination=$lat,$lng" : null,
        ]);
    }
}
