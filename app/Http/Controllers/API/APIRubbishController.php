<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\RubbishStreet;

class APIRubbishController extends Controller
{

    public function streetList()
    {
        return RubbishStreet::current()->get();
    }

    public function pickupItems(RubbishStreet $street)
    {
        return $street->pickupItems();
    }

}