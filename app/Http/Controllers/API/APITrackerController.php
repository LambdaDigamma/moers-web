<?php


namespace App\Http\Controllers\API;

use App\Models\Tracker;

class APITrackerController
{
    public function get()
    {
        $tracker = Tracker::all();

        return response()->json($tracker, 200);
    }
}
