<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RubbishStreet;
use Request;

class APIRubbishController extends Controller
{
    public function streetList()
    {
        $queryTerm = Request::get('q');

        if (Request::has('all')) {
            return RubbishStreet::query()
                ->when($queryTerm, function ($query) use ($queryTerm) {
                    return $query->where('name', 'LIKE', "%{$queryTerm}%");
                })
                ->get();
        } else {
            return RubbishStreet::query()
                ->current()
                ->when($queryTerm, function ($query) use ($queryTerm) {
                    return $query->where('name', 'LIKE', "%{$queryTerm}%");
                })
                ->get();
        }
    }

    public function pickupItems(RubbishStreet $street)
    {
        return $street->pickupItems();
    }
}
