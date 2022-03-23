<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ParkingArea;
use App\Services\NavigationLinkBuilder;
use App\Services\AppleMapSnapshot;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ParkingAreaController extends Controller
{
    public function index()
    {
        return view('parking-area.index', [
            'parkingAreas' => ParkingArea::query()
                ->orderByOpeningState()
                ->get(),
        ]);
    }
    
    public function show($slug)
    {
        $parkingArea = ParkingArea::query()
            ->where('slug', $slug)
            ->firstOrFail();

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

        SEOTools::setTitle($parkingArea->name);

        $lat = $parkingArea->location->getLat();
        $lng = $parkingArea->location->getLng();
        
        $url = AppleMapSnapshot::signedURL('auto', [
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
                ]
            ]
        ]);

        return view('parking-area.show', [
            'parkingArea' => $parkingArea,
            'pastOccupancy' => $pastOccupancy,
            'imageUrl' => $url,
            'lat' => $lat,
            'lng' => $lng,
            'google_maps' => NavigationLinkBuilder::buildGoogleMapsLink($lat, $lng),
        ]);
    }

}