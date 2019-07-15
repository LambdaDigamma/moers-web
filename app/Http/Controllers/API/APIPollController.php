<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Poll;
use Illuminate\Http\Request;

class APIPollController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('get');
    }

    public function get() {

        $polls = Poll::all();

        return response()->json($polls);

    }

    public function show($id) {

        $poll = Poll::findOrFail($id);

        return $poll;

    }

}
