<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdvEvent;
use App\Models\Event;
use Inertia\Inertia;
use Request;

class EventController extends Controller
{

    public function __construct() {
        $this->middleware('can:access-admin');
        $this->middleware('remember')->only('index');
    }

    public function index()
    {
        return Inertia::render('Admin/Events/Index', [
            'filters' => Request::all('search'),
            'events' => //Event::with('organisation', 'entry')
                Event::query()
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
