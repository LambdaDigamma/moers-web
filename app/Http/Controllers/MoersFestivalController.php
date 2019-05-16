<?php

namespace App\Http\Controllers;

use App\Organisation;

class MoersFestivalController extends Controller
{

    public function getEvents() {

        $mfID = 1;

        $organisation = Organisation::find($mfID);

        $events = $organisation->events()->with('entry', 'organisation')->where('is_published', 1)->get();

        return response()->json($events, 200);

    }

}
