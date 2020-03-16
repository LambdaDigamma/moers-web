<?php

namespace App\Http\Controllers\Web;

use App\HelpRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHelpRequest;
use App\Quarter;
use Auth;
use Inertia\Inertia;
use Redirect;
use Request;

class HelpController extends Controller
{

    public function __construct()
    {
        $this->middleware('remember')->only('serve');
    }

    public function index()
    {
        return Inertia::render('Help/Index', [
            'ownHelpRequests' => Auth::user() ? Auth::user()
                ->helpRequests()
                ->with('quarter')
                ->get() : null,
        ]);
    }

    public function serve()
    {
        return Inertia::render('Help/Serve', [
            'filters' => Request::all('search'),
            'helpRequests' => HelpRequest::with('quarter')
                ->orderByDesc('created_at')
                ->filter(Request::only('search'))
                ->paginate()
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

    public function helpRequest(HelpRequest $helpRequest)
    {
        $helpRequest->load('quarter');
        return Inertia::render('Help/HelpRequest', [
            'request' => $helpRequest
        ]);
    }

}
