<?php

namespace App\Http\Controllers\API;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APIEventController extends Controller
{

    public function getEvents() {

        return Event::all();

    }

}
