<?php

namespace App\Http\Controllers\API;

use App\Group;
use App\Http\Controllers\Controller;
use App\Poll;
use App\PollOption;
use Bouncer;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Validator;

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
            'options' => 'required|array|min:2|max:255',
            'options.*' => 'required|string|min:1',
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

    private function errorResponse($message, $status) {
        return response(['errors' => ['common' => [$message]]], $status);
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
