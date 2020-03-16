<?php

namespace App\Http\Controllers\Web;

use App\HelpRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHelpRequest;
use App\Quarter;
use Auth;
use Bouncer;
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

    public function helpRequest(HelpRequest $helpRequest)
    {
        $helpRequest->load('quarter');
        return Inertia::render('Help/HelpRequest', [
            'request' => $helpRequest,
            'isCreator' => $helpRequest->creator_id === Auth::user()->id
        ]);
    }

    public function sendHelpRequest(StoreHelpRequest $request)
    {
        $validated = $request->validated();

        $helpRequest = Auth::user()->helpRequests()->create($validated);

        Bouncer::allow(Auth::user())->to('delete', $helpRequest);

        return Redirect::route('help.index')->with('success', 'Deine Suche nach Hilfe wurde gespeichert.');

    }

    public function deleteHelpRequest(HelpRequest $helpRequest)
    {

        if (Bouncer::can('delete', $helpRequest)) {
            $helpRequest->delete();
            return Redirect::route('help.index')->with('success', 'Die Hilfesuche wurde erfolgreich gelöscht.');
        } else {
            return response('Unauthorized.', 401);
        }

    }

}
