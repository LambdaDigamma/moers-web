<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ParkingArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use League\Csv\Reader;

class ParkingAreaController extends Controller
{
    public function index()
    {
        $exitCode = Artisan::call('parking-area:update');

        // if ($exitCode == 0) {
        //     return ParkingArea::all();
        // } else if ($exitCode == 1) {
        //     return ParkingArea::all();
        // }

        return new JsonResponse([
            'data' => [
                'parking_areas' => ParkingArea::query()
                    ->get(),
            ]
        ], Response::HTTP_OK);
    }
}