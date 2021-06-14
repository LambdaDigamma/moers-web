<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AdvEvent;
use App\Models\Event;
use Artesaos\SEOTools\Facades\JsonLdMulti;
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

        $eventLd = JsonLdMulti::newJsonLd();
        $eventLd->setType('Event');
        $eventLd->setTitle($event->name);
        $eventLd->setDescription($event->description);

        if ($event->extras && $event->extras->get('street')) {
            $eventLd->addValues([
                'address' => [
                    "@type" => "PostalAddress",
                    "addressLocality" => "USA, CA",
                    "postalCode" => $event->extras->get('postcode'),
                    "streetAddress" => $event->extras->get('street'),
                    "addressCountry" => "DE",
                ]
            ]);
        }

        $eventLd->addValues([
            'startDate' => $event->start_date->tz('UTC'),
            'endDate' => $event->end_date,
        ]);
            
        if (! $event->isOnline) {
            $eventLd->addValue("eventAttendanceMode", "https://schema.org/OfflineEventAttendanceMode");
            $eventLd->addValues([
                'location' => [
                    '@type' => 'VirtualLocation',
                    // 'url' => 'https://operaonline.stream5.com/'
                ]
            ]);

        } else {
            $eventLd->addValue("eventAttendanceMode", "https://schema.org/OnlineEventAttendanceMode");

        }

            
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
