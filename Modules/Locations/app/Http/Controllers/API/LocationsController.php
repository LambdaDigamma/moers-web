<?php

namespace Modules\Locations\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Locations\Models\Location;

class LocationsController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Location::query()
                ->with('media')
                ->orderBy('id')
                ->get()
        );
    }

    public function show(Location $location): JsonResponse
    {
        $location->load('media');

        return response()->json($location);
    }
}
