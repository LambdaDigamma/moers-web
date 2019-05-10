<?php

namespace App\Http\Controllers;

use App\Organisation;
use Illuminate\Http\Request;

class MoersFestivalController extends Controller
{

    public function getEvents() {

        $mfID = 1;

        $organisation = Organisation::find($mfID);

        $events = $organisation->events()->with('entry', 'organisation')->where('is_published', 1)->get();

        return response()->header('Cache-Control', 'max-age=14400, public')->json($events, 200);

    }

}
