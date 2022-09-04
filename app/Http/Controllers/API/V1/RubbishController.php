<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\RubbishStreet;
use Illuminate\Http\JsonResponse;
use Request;

class RubbishController extends Controller
{
    public function streetList()
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

            return new JsonResponse(['data' => $data], 200);
        } else {
            $data = RubbishStreet::query()
                ->current()
                ->when($queryTerm, function ($query) use ($queryTerm) {
                    return $query
                        ->where('name', 'LIKE', "%{$queryTerm}%");
                })
                ->orderBy('name')
                ->get();

            return new JsonResponse(['data' => $data], 200);
        }
    }

    public function pickupItems(RubbishStreet $street)
    {
        return new JsonResponse(['data' => $street->pickupItems()], 200);
    }
}
