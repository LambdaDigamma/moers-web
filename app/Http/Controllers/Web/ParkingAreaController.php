<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ParkingArea;
use App\Services\WebSnapshot;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;

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
                // 'max_capacity' => 10,
                'data' => $data,
            ];
        });

        SEOTools::setTitle($parkingArea->name);

        // '51.449781,6.631362'
        $url = WebSnapshot::signedURL('auto', [
            'z' => '13',
            'lang' => 'de-DE',
            'scale' => 2,
            'poi' => 0,
            'annotations' => [
                [
                    'point' => '51.449781,6.631362', 
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
        ]);
    }

    private function loadMapImage($lat, $lng)
    {
        $params = "center=\"${lat},${lng}\"";
        $imageUrl = "https://snapshot.apple-mapkit.com" . $this->signRequest($params);

        dd($imageUrl);
        return $imageUrl;
    }
    
    private function signRequest(string $params): string
    {
        $teamId = "93C29USLP6";
        $keyId = "BGVVMUBP5L";
        $mapKey = config('services.apple.maps_key');

        $snapshotPath = "/api/v1/snapshot?${params}";
        $completePath = "${snapshotPath}&teamId=${teamId}&keyId=${keyId}";

        $signer = new Sha256();
        // $privateKey = new InMemory($contents, $passphrase);
        // $privateKey = InMemory::plainText($mapKey);
        $privateKey = openssl_pkey_get_private($mapKey);
        openssl_sign($completePath, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        // $signature = $signer->sign($completePath, $privateKey);
        $encodedSignature = $this->encode($signature);
        
        return "${completePath}&signature=${encodedSignature}";
    }

    /**
     * Encode String.
     *
     * @param [string] $string String to be encoded.
     * @return [string]
     */
    function encode($string) {
        return urlencode(base64_encode($string));

        $response = strtr(base64_encode($string), '+/', '-_');
        return rtrim($response, '=');
    }
}