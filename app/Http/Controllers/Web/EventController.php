<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AdvEvent;
use App\Models\Event;
use Artesaos\SEOTools\Facades\SEOTools;
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

    public function show(Event $event)
    {
        SEOTools::setTitle($event->name);
        SEOTools::setDescription($event->description);

        // $event->load(['organisation'])

        return view('pages.events.show', [
            'event' => $event
        ]);
    }

    // public function show(AdvEvent $event)
    // {
    //     if ($event->scheduled_at != null && $event->scheduled_at > now()->toDateTimeString()) {
    //         return Redirect::route('events.index');
    //     }

    //     $event->load(['organisation', 'page', 'page.blocks', 'entry']);
    //     return Inertia::render('Event/Show', [
    //         'event' => $event
    //     ]);
    // }
}
