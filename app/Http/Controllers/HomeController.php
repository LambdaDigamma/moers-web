<?php

namespace App\Http\Controllers;

use App\Models\AdvEvent;
use App\Models\Event;
use App\Models\ParkingArea;
use App\Models\Post;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function __invoke(Request $request)
    {
        SEOTools::setTitle("Übersicht");
        
        $events = Event::query()->chronological()
            ->upcomingToday()
            ->limit(20)
            ->get();
        $parkingAreas = Cache::remember('home_parking_state', 60, function () {
            return ParkingArea::query()
                ->open()
                ->get();
        });

        $news = Cache::remember('home_news', 60, function () {
            return Post::query()
                ->orderByDesc('published_at')
                ->limit(8)
                ->get();
        });

        // $events = AdvEvent::future()->chronological()->limit(10)->get();

        return view('home', [
            'events' => $events,
            'parkingAreas' => $parkingAreas,
            'news' => $news,
        ]);
    }
}
