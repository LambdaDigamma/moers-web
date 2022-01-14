<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ParkingArea;
use Illuminate\Support\Facades\Artisan;

class ParkingAreaController extends Controller
{
    public function index()
    {
        $exitCode = Artisan::call('parking-area:update');

        return view('parking-area.index', [
            'parkingAreas' => ParkingArea::query()
                ->orderByRaw("FIELD(current_opening_state, 'open', 'closed', 'unknown')")
                ->get(),
        ]);
    }
}