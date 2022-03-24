<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\ParkingArea;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ParkingAreaRecentHistory extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $parkingAreaID = $request->query('parking_area_id');
        $parkingArea = ParkingArea::find($parkingAreaID);

        if ($parkingArea == null) {
            return Chartisan::build()
                ->labels([])
                ->dataset('Letzte 24h', []);
        }

        $pastOccupancy = Cache::remember('api_past_occupancy_parking_area_' . $parkingArea->id, 1, function () use ($parkingArea) {
            $data = DB::table('parking_area_occupancies')
                ->selectRaw('avg(occupancy_rate) as occupancy_rate, HOUR(created_at) as hour')
                ->where('parking_area_id', $parkingArea->id)
                ->whereRaw('created_at >= NOW() - INTERVAL 23 HOUR')
                ->groupBy('hour')
                ->orderBy('created_at')
                ->get();

            return [
                'data' => $data,
            ];
        });

        $labels = $pastOccupancy['data']->map(function ($item) {
            return $item->hour;
        })->toArray();
        $occupancy = $pastOccupancy['data']->map(function ($item) {
            return (double) $item->occupancy_rate;
        })->toArray();

        return Chartisan::build()
            ->labels($labels)
            ->dataset('Letzte 24h', $occupancy);
    }
}