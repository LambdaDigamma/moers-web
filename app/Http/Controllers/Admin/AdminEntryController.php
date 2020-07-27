<?php

namespace App\Http\Controllers\Admin;

use App\Entry;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUpdateEntry;
use Inertia\Inertia;
use Redirect;
use Request;

class AdminEntryController extends Controller
{

    public function __construct() {
        $this->middleware('can:access-admin');
        $this->middleware('remember')->only('index');
    }

    public function index()
    {
        return Inertia::render('Admin/Entries/Index', [
            'filters' => Request::all('search'),
            'entries' => Entry::with('organisations')
                ->orderByDesc('name')
                ->filter(Request::only('search'))
                ->paginate(12)
        ]);
    }

    public function edit(Entry $entry)
    {
        return Inertia::render('Admin/Entries/Edit', [
            'entry' => $entry
        ]);
    }

    public function update(Entry $entry, AdminUpdateEntry $request)
    {
        $data = $request->validated();
        $entry->update($data);

        return Redirect::back()->with('success', 'Die Informationen wurden erfolgreich gespeichert.');
    }

}
