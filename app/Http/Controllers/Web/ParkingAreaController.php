<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ParkingArea;
use Illuminate\Support\Facades\Artisan;

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
}