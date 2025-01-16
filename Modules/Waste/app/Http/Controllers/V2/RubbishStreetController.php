<?php

namespace Modules\Waste\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Modules\Waste\Models\RubbishStreet;

class RubbishStreetController extends Controller
{
    public function index(): JsonResponse
    {
        $queryTerm = Request::get('q');

        if (Request::has('all')) {
            $data = RubbishStreet::query()
                ->when($queryTerm, function ($query) use ($queryTerm) {
                    return $query
                        ->where('name', 'LIKE', "%{$queryTerm}%");
                })
                ->orderBy('name')
                ->get();

        } else {
            $data = RubbishStreet::query()
                ->current()
                ->when($queryTerm, function ($query) use ($queryTerm) {
                    return $query
                        ->where('name', 'LIKE', "%{$queryTerm}%");
                })
                ->orderBy('name')
                ->get();

        }

        return new JsonResponse($data, 200);
    }

    public function show(RubbishStreet $street): JsonResponse
    {
        return new JsonResponse($street->pickupItems(), 200);
    }
}
