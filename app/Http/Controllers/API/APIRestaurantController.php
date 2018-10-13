<?php

namespace App\Http\Controllers\API;

use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APIRestaurantController extends Controller
{

    public function getRestaurants() {

        return Restaurant::where('validated', '=', '1')->get();

    }

}
