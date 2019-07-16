<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Poll;
use Illuminate\Http\Request;

class APIPollController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('get', 'show');
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
