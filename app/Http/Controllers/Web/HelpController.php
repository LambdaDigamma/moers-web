<?php

namespace App\Http\Controllers\Web;

use App\Conversation;
use App\Events\MessageWasPosted;
use App\Events\UserJoinedConversation;
use App\HelpRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendMessage;
use App\Http\Requests\StoreHelpRequest;
use App\Message;
use App\Notifications\ClosedHelpRequestNotification;
use App\Notifications\CompletedHelpRequestNotification;
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
                ->with(['quarter', 'helper:id', 'creator:id'])
                ->get() : null,
            'userActiveHelpRequests' => Auth::user() ?
                HelpRequest::with('quarter', 'helper:id', 'creator:id')
                ->userHelps()
                ->withoutOwn()
                ->get() : null,
            'openHelpRequests' => HelpRequest::with('quarter', 'helper:id', 'creator:id')
                ->withoutOwn()
                ->notServed()
                ->orderByDesc('created_at')
                ->get()
        ]);
    }

    public function serve()
    {
        return Inertia::render('Help/Serve', [
            'activeRequests' => Auth::user() ?
                HelpRequest::with('quarter', 'helper:id', 'creator:id')
                    ->userHelps()
                    ->withoutOwn()
                    ->get() : null,
            'filters' => Request::all('search'),
            'helpRequests' => HelpRequest::with('quarter', 'helper:id', 'creator:id')
                ->notServed()
                ->withoutOwn()
                ->orderByDesc('created_at')
                ->filter(Request::only('search'))
                ->paginate()
        ]);
    }

    public function need()
    {
        return Inertia::render('Help/Need', [
            'quarters' => Quarter::all(),
            'activeRequests' => Auth::user() ? Auth::user()
                ->helpRequests()
                ->with(['quarter', 'helper:id', 'creator:id'])
                ->get() : null,
        ]);
    }

    public function helpRequest(HelpRequest $helpRequest)
    {
        $helpRequest->load('quarter');

        if ($helpRequest->helper == null) {
            $helpRequest->load(['conversation', 'conversation.messages']);
            return Inertia::render('Help/HelpRequest', [
                'request' => $helpRequest,
                'isCreator' => $helpRequest->creator_id === Auth::user()->id,
                'messages' => null
            ]);
        }

        if ($helpRequest->helper->id == Auth::user()->id ||
            $helpRequest->creator->id == Auth::user()->id) {
            $helpRequest->load(['creator', 'helper', 'conversation', 'conversation.messages']);
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
        $conversation = Conversation::create();
        $helpRequest->conversation()->associate($conversation)->save();
        $conversation->users()->save($helpRequest->creator);

        Bouncer::allow(Auth::user())->to('delete', $helpRequest);

        return Redirect::route('help.index')->with('success', 'Deine Suche nach Hilfe wurde gespeichert.');

    }

    public function acceptHelpRequest(HelpRequest $helpRequest)
    {

        if ($helpRequest->served_on == null) {
            $helpRequest->served_on = Carbon::now();
            $helpRequest->helper()->associate(Auth::user());
            $helpRequest->conversation->users()->save($helpRequest->helper);
            $helpRequest->save();
            event(new UserJoinedConversation(Auth::user(), $helpRequest->conversation));
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

            $helpRequest->conversation->delete();
            $helpRequest->delete();

            return Redirect::route('help.index')->with('success', 'Die Hilfesuche wurde erfolgreich gelöscht.');

        } else {
            return response('Unauthorized.', 401);
        }

    }

    public function done(HelpRequest $helpRequest)
    {
        if (Bouncer::can('delete', $helpRequest)) {

            if (!is_null($helpRequest->helper)) {
                $helpRequest->helper->notify(new CompletedHelpRequestNotification());
            }

            $helpRequest->conversation->delete();
            $helpRequest->delete();

            return Redirect::route('help.index')->with('success', 'Die Hilfesuche wurde als erledigt markiert.');

        } else {
            abort(403, 'Du darfst nicht auf diese Seite zugreifen.');
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
