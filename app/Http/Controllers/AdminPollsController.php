<?php

namespace App\Http\Controllers;

use App\Poll;
use Inertia\Inertia;
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

}
