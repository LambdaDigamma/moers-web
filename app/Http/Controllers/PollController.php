<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbstainPoll;
use App\Http\Requests\VotePoll;
use App\Poll;
use App\PollOption;
use App\Vote;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Request;

class PollController extends Controller
{

    public function __construct()
    {
        $this->middleware('remember')->only('index');
    }

    public function index()
    {
        return Inertia::render('Polls/Index', [
            'filters' => Request::all('search'),
            'polls' => Auth::user()
                ->polls()
                ->unanswered()
                ->filter(Request::only('search'))
                ->paginate()
        ]);
    }

    public function show(Poll $poll)
    {
        return Inertia::render('Polls/Show', [
            'poll' => $poll->load('options'),
            'nextPollId' => Auth::user()
                ->polls()
                ->unanswered()
                ->first()->id
        ]);
    }

    public function indexAnswered()
    {
        return Inertia::render('Polls/IndexAnswered', [
            'filters' => Request::all('search'),
            'polls' => Auth::user()
                ->polls()
                ->answered()
                ->filter(Request::only('search'))
                ->paginate()
        ]);
    }

    /*
     * Actions
     */

    public function vote(VotePoll $request, Poll $poll)
    {
        if ($poll->canUserVote()) {

            $user_id = $request->user()->id;

            if (Vote::where([['poll_id', $poll->id], ['user_id', $user_id]])->count() == 0) {

                $option_ids = $request->json()->get('options');

                PollOption::whereIn('id', $option_ids)->increment('votes');

                $vote = new Vote(['poll_id' => $poll->id, 'user_id' => $user_id]);
                $vote->save();

                return Redirect::route('polls.show', $poll)
                    ->with('success', 'Erfolgreich abgestimmt.');

            } else {
                return Redirect::route('polls.show', $poll)
                    ->withErrors('Du hast schon an dieser Abstimmung teilgenommen.');
            }

        } else {
            return Redirect::route('polls.show', $poll)
                ->withErrors('Du bist kein Mitglied dieser Gruppe.');
        }
    }

    public function abstain(AbstainPoll $request, Poll $poll)
    {

        $user_id = $request->user()->id;

        if (Vote::where([['poll_id', $poll->id], ['user_id', $user_id]])->count() == 0) {

            $vote = new Vote(['poll_id' => $poll->id, 'user_id' => $user_id]);
            $vote->save();

            return Redirect::route('polls.show', $poll)
                ->with('success', 'Erfolgreich enthalten.');

        } else {
            return Redirect::route('polls.show', $poll)
                ->withErrors('Du hast schon an dieser Abstimmung teilgenommen.');
        }

    }

}
