<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\UpdatePoll;
use App\Poll;
use Inertia\Inertia;
use Redirect;
use Request;

class AdminPollsController extends Controller
{

    public function __construct()
    {
//        $this->middleware('can:access-admin');
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

    public function create()
    {
        return Inertia::render('Admin/Polls/Create', [
            'groups' => Group::with('organisation')->get()
        ]);
    }

}
