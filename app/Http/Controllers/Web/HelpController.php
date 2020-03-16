<?php

namespace App\Http\Controllers\Web;

use App\HelpRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHelpRequest;
use App\Quarter;
use Auth;
use Inertia\Inertia;
use Redirect;

class HelpController extends Controller
{

    public function index()
    {
        return Inertia::render('Help/Index', [

        ]);
    }

    public function serve()
    {
        return Inertia::render('Help/Serve', [
            'helpRequests' => HelpRequest::with('quarter')->get()
        ]);
    }

    public function need()
    {
        return Inertia::render('Help/Need', [
            'quarters' => Quarter::all()
        ]);
    }

    public function sendHelpRequest(StoreHelpRequest $request)
    {
        $validated = $request->validated();

        $helpRequest = Auth::user()->helpRequests()->create($validated);

        return Redirect::route('help.index')->with('success', 'Deine Suche nach Hilfe wurde gespeichert.');

    }

    public function helpRequest()
    {
        return Inertia::render('Help/HelpRequest');
    }

}
