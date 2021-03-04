<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Poll;
use App\Models\Vote;
use App\PollOption;
use App\Rules\CheckPollHasOption;
use App\Rules\SatisfiesPollOptionsMaxCheck;
use Bouncer;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Validator;

class APIPollController extends Controller
{

    /**
     * APIPollController constructor.
     * Adds a middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth:api']);
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

    /**
     * Returns the Poll with its related options. Returns an error if no Poll exists for the given $id.
     *
     * @param $id
     *
     * @return \App\Models\Poll
     */
    public function show($id)
    {
        return Poll::with(['options'])->findOrFail($id);
    }

    /**
     * Returns all answered Polls for the authenticated User.
     *
     * @param Request $request
     * @return Collection
     */
    public function answeredPolls(Request $request)
    {
        $user = $request->user();
        return $user->polls()->filter(function ($poll) {
            return $poll->hasUserVote();
        });
    }

    /**
     * Returns all unanswered Polls for the authenticated User.
     *
     * @param Request $request
     * @return Collection
     */
    public function unansweredPolls(Request $request)
    {
        $user = $request->user();
        return $user->polls()->filter(function ($poll) {
            return !$poll->hasUserVote();
        });
    }

    /**
     * Validates and Stores a Poll based on the given inputs.
     * Returns the stored Poll or errors if validation or authentication failed.
     *
     * @param Request $request
     * @return ResponseFactory|JsonResponse|Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|min:3|max:500',
            'description' => 'required|string|min:3',
            'group_id' => 'required|integer|exists:groups,id',
            'options' => 'required|array|min:2|max:40',
            'options.*' => 'required|string|min:1|max:255',
            'max_check' => 'required|integer|min:1' // TODO: Make working! 'lt:options'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $group = Group::findOrFail($request->json()->get('group_id'));

        if (Bouncer::can('create-poll-group', $group)) {
            $poll = Poll::create($request->json()->all());

            $options = $request->json()->get('options');

            foreach ($options as $option) {
                $option = PollOption::create(['name' => $option, 'poll_id' => $poll->id]);
                $poll->options()->save($option);
            }

            return response()->json($poll);
        } else {
            return $this->errorResponse("You are not allowed to create a Poll for this Group.", 403);
        }
    }

    /**
     * Marks the given Poll as abstained. Returns an error if User is not allowed to vote for this poll.
     *
     * @param Request          $request
     * @param \App\Models\Poll $poll
     *
     * @return ResponseFactory|JsonResponse|Response
     */
    public function abstain(Request $request, Poll $poll)
    {
        if ($poll->canUserVote()) {
            $user_id = $request->user()->id;

            if (Vote::where([['poll_id', $poll->id], ['user_id', $user_id]])->count() == 0) {
                $vote = new Vote(['poll_id' => $poll->id, 'user_id' => $user_id]);
                $vote->save();

                return response()->json(['vote' => $vote, 'poll' => $poll]);
            } else {
                return $this->errorResponse("You already voted for this poll.", 403);
            }
        } else {
            return $this->errorResponse("You are not a member of this group.", 403);
        }
    }

    /**
     * Increments the votes of the selected options provided in the request.
     * Returns the created Vote for the User and the Poll with result or
     * returns an error if the authenticated User is not allowed to vote for this poll.
     *
     * @param Request          $request
     * @param \App\Models\Poll $poll
     *
     * @return ResponseFactory|JsonResponse|Response
     */
    public function vote(Request $request, Poll $poll)
    {
        if ($poll->canUserVote()) {
            $user_id = $request->user()->id;

            if (Vote::where([['poll_id', $poll->id], ['user_id', $user_id]])->count() == 0) {
                $validator = Validator::make($request->all(), [
                    'options' => ['required', 'array', 'min:1', new SatisfiesPollOptionsMaxCheck($poll)],
                    'options.*' => ['required', 'integer', 'exists:poll_options,id', new CheckPollHasOption($poll)]
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $option_ids = $request->json()->get('options');

                PollOption::whereIn('id', $option_ids)->increment('votes');

                $vote = new Vote(['poll_id' => $poll->id, 'user_id' => $user_id]);
                $vote->save();

                return response()->json(['vote' => $vote, 'poll' => $poll]);
            } else {
                return $this->errorResponse("You already voted for this poll.", 403);
            }
        } else {
            return $this->errorResponse("You are not a member of this group.", 403);
        }
    }

    /**
     * Creates JSON Response in a common error format. The $message will be returned as a common error.
     *
     * @param $message
     * @param $status
     * @return ResponseFactory|Response
     */
    private function errorResponse($message, $status)
    {
        return response(['errors' => ['common' => [$message]]], $status);
    }
}
