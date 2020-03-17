<?php

namespace App\Http\Controllers\Web;

use App\Conversation;
use App\Events\MessageWasPosted;
use App\HelpRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendMessage;
use App\Http\Requests\StoreHelpRequest;
use App\Message;
use App\Notifications\ClosedHelpRequestNotification;
use App\Quarter;
use Auth;
use Bouncer;
use Carbon\Carbon;
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

        if ($helpRequest->helper == null) {
            return Inertia::render('Help/HelpRequest', [
                'request' => $helpRequest,
                'isCreator' => $helpRequest->creator_id === Auth::user()->id,
                'messages' => null
            ]);
        }

        if ($helpRequest->helper->id == Auth::user()->id ||
            $helpRequest->creator->id == Auth::user()->id) {
            $helpRequest->load(['creator', 'helper', 'conversation', 'conversation.messages']);
            $helpRequest->creator['name'] = explode(" ", $helpRequest->creator['name'])[0];
            $helpRequest->helper['name'] = explode(" ", $helpRequest->helper['name'])[0];
            return Inertia::render('Help/HelpRequest', [
                'request' => $helpRequest,
                'isCreator' => $helpRequest->creator_id === Auth::user()->id,
                'messages' => function () use ($helpRequest) {
                    return ($helpRequest->conversation !== null) ? $helpRequest->conversation->messages
                         : null;
                },
            ]);
        } else {
            abort(403, 'Du darfst nicht auf diese Seite zugreifen.');
        }

    }

    public function sendHelpRequest(StoreHelpRequest $request)
    {
        $validated = $request->validated();

        $helpRequest = Auth::user()->helpRequests()->create($validated);

        Bouncer::allow(Auth::user())->to('delete', $helpRequest);

        return Redirect::route('help.index')->with('success', 'Deine Suche nach Hilfe wurde gespeichert.');

    }

    public function acceptHelpRequest(HelpRequest $helpRequest)
    {

        if ($helpRequest->served_on == null) {

            $helpRequest->helper()->associate(Auth::user());
            $helpRequest->served_on = Carbon::now();
            $conversation = Conversation::create();
            $conversation->users()->saveMany([$helpRequest->creator, $helpRequest->helper]);
            $helpRequest->conversation()->associate($conversation);
            $helpRequest->save();
            return Redirect::route('help.request.show', $helpRequest->id)
                ->with('success', 'Du hast den Kontakt aufgebaut und kannst jetzt die Kommunikation beginnen.');
        } else {
            return Redirect::route('help.request.show', $helpRequest->id)
                ->withErrors('Ein anderer Nutzer hilft bereits.');
        }

    }

    public function deleteHelpRequest(HelpRequest $helpRequest)
    {

        if (Bouncer::can('delete', $helpRequest)) {

            if (!is_null($helpRequest->helper)) {
                $helpRequest->helper->notify(new ClosedHelpRequestNotification());
            }

            $helpRequest->delete();

            return Redirect::route('help.index')->with('success', 'Die Hilfesuche wurde erfolgreich gelöscht.');

        } else {
            return response('Unauthorized.', 401);
        }

    }

    public function sendMessage(HelpRequest $helpRequest, SendMessage $messageRequest) {

        $message = Message::make($messageRequest->validated());
        $message->sender()->associate(Auth::user());

        $helpRequest->conversation->messages()->save($message);

        event(new MessageWasPosted($message));

        return Redirect::route('help.request.show', $helpRequest->id);

    }

}
