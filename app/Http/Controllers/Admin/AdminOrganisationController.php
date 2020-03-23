<?php

namespace App\Http\Controllers\Admin;

use App\AdvEvent;
use App\Entry;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEvent;
use App\Organisation;
use Inertia\Inertia;
use Redirect;
use Request;

class AdminOrganisationController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:access-admin');
        $this->middleware('remember')->only('index');
    }

    public function index()
    {
        return Inertia::render('Admin/Organisations/Index', [
            'filters' => Request::all('search'),
            'organisations' => Organisation::with(['mainGroup', 'entry'])
                ->orderByDesc('name')
                ->filter(Request::only('search'))
                ->paginate()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Organisations/Create');
    }

    public function edit(Organisation $organisation)
    {
        return Inertia::render('Admin/Organisations/Edit', [
            'organisation' => $organisation,
            'events' => $organisation->events()->take(3)->get()
        ]);
    }

    public function createEvent(Organisation $organisation)
    {
        return Inertia::render('Admin/Organisations/CreateEvent', [
            'organisation' => $organisation,
            'entries' => Entry::all(),
        ]);
    }

    public function storeEvent(Organisation $organisation, UpdateEvent $request)
    {

        $validated = $request->validated();

        $event = AdvEvent::create($validated);

        if (Request::has('header_image')) {
            $event->addMediaFromRequest('header_image')
                  ->toMediaCollection('header');
        }

        $organisation->events()->save($event);

        return Redirect::route('admin.organisations.events.edit', [$organisation->id, $event->id]);

    }

    public function editEvent(Organisation $organisation, AdvEvent $event, string $lang = "de")
    {

        app()->setLocale($lang);

        return Inertia::render('Admin/Organisations/EditEvent', [
            'organisation' => $organisation,
            'event' => $event,
            'lang' => $lang
        ]);
    }

    public function updateEvent(Organisation $organisation, AdvEvent $event, UpdateEvent $request, string $lang = "de")
    {

        app()->setLocale($lang);

        if ($lang != "de") {
            $event->setTranslation('name', $lang, $request->get('name'));
            $event->setTranslation('description', $lang, $request->get('description'));
            $event->setTranslation('category', $lang, $request->get('category'));
            $event->save();
        } else {
            $validated = $request->validated();
            $event->update($validated);
        }

        if (Request::has('header_image') && Request::get('header_image') !== null) {
            $event->clearMediaCollection('header');
            $event->addMediaFromRequest('header_image')
                  ->toMediaCollection('header');
        }

        return Redirect::route('admin.organisations.events.edit', [$organisation->id, $event->id, $lang]);

    }

    public function destroy(Organisation $organisation)
    {
        $organisation->delete();

        return Redirect::back()->with('success', 'Organisation gelöscht.');
    }

    public function restore(Organisation $organisation)
    {
        $organisation->restore();

        return Redirect::back()->with('success', 'Organisation wiederhergestellt.');
    }

}
