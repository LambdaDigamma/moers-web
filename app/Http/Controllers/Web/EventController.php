<?php


namespace App\Http\Controllers\Web;


use App\AdvEvent;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Redirect;

class EventController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {

        return Inertia::render('Event/Index', [
            'todayEvents' => AdvEvent::with('organisation')->published()->active()->chronological()->get(),
            'todayUpcoming' => AdvEvent::with('organisation')->published()->today()->chronological()->upcomingToday()->get(),
            'nextUpcoming' => AdvEvent::with('organisation')->published()->nextDays()->chronological()->get()
        ]);

    }

    public function show(AdvEvent $event)
    {

        if ($event->scheduled_at != null && $event->scheduled_at > now()->toDateTimeString()) {
            return Redirect::route('events.index');
        }

        $event->load(['organisation', 'page', 'page.blocks', 'entry']);
        return Inertia::render('Event/Show', [
            'event' => $event
        ]);

    }

}