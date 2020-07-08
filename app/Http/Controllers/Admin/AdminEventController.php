<?php

namespace App\Http\Controllers\Admin;

use App\AdvEvent;
use App\Entry;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUpdateEntry;
use Inertia\Inertia;
use Redirect;
use Request;

class AdminEventController extends Controller
{

    public function __construct() {
        $this->middleware('can:access-admin');
        $this->middleware('remember')->only('index');
    }

    public function index()
    {
        return Inertia::render('Admin/Events/Index', [
            'filters' => Request::all('search'),
            'events' => AdvEvent::with('organisation', 'entry')
                ->chronological()
                ->filter(Request::only('search'))
                ->paginate(9)
        ]);
    }

    public function edit(AdvEvent $event)
    {
        return Inertia::render('Admin/Events/Edit', [
            'event' => $event
        ]);
    }

//    public function update(Entry $entry, AdminUpdateEntry $request)
//    {
//        $data = $request->validated();
//        $entry->update($data);
//
//        return Redirect::back()->with('success', 'Die Informationen wurden erfolgreich gespeichert.');
//    }

}
