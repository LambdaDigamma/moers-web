<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function createEvent()
    {
        return Inertia::render('Admin/Organisations/CreateEvent');
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
