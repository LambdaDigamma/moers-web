<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use Illuminate\Http\JsonResponse;

class TrackerController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Tracker::query()
                ->orderBy('id')
                ->get()
        );
    }
}
