<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class APIPollController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api', 'can:read-poll']);
//        $this->middleware('auth:api')->except('get', 'show');
    }


    /**
     * Returns all Polls for the authenticated User.
     *
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request)
    {
        return $request->user()->polls();
    }

    public function answeredPolls(Request $request)
    {
        $user = $request->user();
        return $user->polls()->filter(function ($poll) {
            return $poll->hasUserVote();
        });
    }

    public function unansweredPolls(Request $request)
    {
        $user = $request->user();
        return $user->polls()->filter(function ($poll) {
            return !$poll->hasUserVote();
        });
    }




    public function vote() {



    }

    public function get() {

        $polls = Poll::with(['options'])->get();

        return response()->json($polls);

    }

    public function show($id) {
        
        $poll = Poll::with(['options'])->findOrFail($id);

        return $poll;

    }

}
