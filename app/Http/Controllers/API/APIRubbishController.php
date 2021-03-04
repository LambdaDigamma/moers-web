<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RubbishStreet;
use Request;

class APIRubbishController extends Controller
{
    public function streetList()
    {
        if (Request::has('all')) {
            return RubbishStreet::all();
        } else {
            return RubbishStreet::current()->get();
        }
    }

    public function pickupItems(RubbishStreet $street)
    {
        return $street->pickupItems();
    }
}
