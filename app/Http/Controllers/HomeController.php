<?php

namespace App\Http\Controllers;

use App\Models\AdvEvent;
use App\Models\Event;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        SEOTools::setTitle("Übersicht");
//        SEOTools::setDescription($page->summary);

        $events = Event::query()->chronological()->upcoming()->limit(20)->get();

        // $events = AdvEvent::future()->chronological()->limit(10)->get();

//        dd($events);
        return view('home', [
            'events' => $events
        ]);
    }
}
