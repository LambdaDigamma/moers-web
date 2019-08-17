<?php

namespace App\Http\Controllers\API;

use App\Group;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class APIGroupController extends Controller
{

    /**
     * APIGroupController constructor.
     * Adds a middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /**
     * Returns a Collection of Groups that the authenticated User is associated with.
     *
     * @return Collection
     */
    public function index()
    {
        return Auth::user()->groups;
    }

}
