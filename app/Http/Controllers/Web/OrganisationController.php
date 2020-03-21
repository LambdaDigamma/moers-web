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
            'organisation' => $organisation->load(['events', 'events.organisation', 'events.entry'])
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