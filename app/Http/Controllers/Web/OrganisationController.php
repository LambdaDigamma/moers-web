<?php


namespace App\Http\Controllers\Web;


use App\AdvEvent;
use App\Http\Controllers\Controller;
use App\Organisation;
use Inertia\Inertia;

class OrganisationController extends Controller
{

    public function show(Organisation $organisation)
    {
        return Inertia::render('Organisations/Show', [
            'organisation' => $organisation->load([
                'publishedEvents',
                'publishedEvents.organisation',
                'publishedEvents.entry'
            ]),
            'todayEvents' => $organisation->events()->published()->active()->chronological()->get(),
            'todayUpcoming' => $organisation->events()->published()->today()->chronological()->upcomingToday()->get(),
            'nextUpcoming' => $organisation->events()->published()->nextDays()->chronological()->get()
        ]);
    }

    public function event(Organisation $organisation, AdvEvent $event)
    {
        return Inertia::render('Organisations/Event', [
            'organisation' => $organisation,
            'event' => $event
        ]);
    }


}