<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePoll;
use App\Http\Requests\UpdatePoll;
use App\Models\Group;
use App\Poll;
use App\PollOption;
use Inertia\Inertia;
use Redirect;
use Request;

class AdminPollsController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:access-admin');
        $this->middleware('remember')->only('index');
    }

    public function index()
    {
        return Inertia::render('Admin/Polls/Index', [
            'filters' => Request::all('search'),
            'polls' => Poll::with(['group', 'group.organisation'])
                           ->orderByDesc('created_at')
                           ->filter(Request::only('search'))
                           ->paginate()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Polls/Create', [
            'groups' => Group::with('organisation')->get()
        ]);
    }

    public function store(StorePoll $request)
    {
        $validated = $request->validated();
        $poll = Poll::create($validated);
        $poll->save();

        $options = $request->json()->get('options');

        foreach ($options as $option) {
            $option = PollOption::create(['name' => $option, 'poll_id' => $poll->id]);
            $poll->options()->save($option);
        }

        return Redirect::route('admin.polls.index', $poll)
            ->with('success', 'Abstimmung hinzugefügt.');
    }

    public function edit(Poll $poll)
    {
        return Inertia::render('Admin/Polls/Edit', [
            'poll' => $poll,
            'results' => $poll->results()
        ]);
    }

    public function update(Poll $poll, UpdatePoll $request)
    {
        $validated = $request->validated();
        $poll->update($validated);
        $poll->save();

        return Redirect::route('admin.polls.edit', $poll)
            ->with('success', 'Abstimmung aktualisiert.');
    }

}
