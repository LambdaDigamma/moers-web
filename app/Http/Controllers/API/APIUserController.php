<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APIUserController extends Controller
{


    /**
     * Returns all Users.
     * @return User[]|Collection
     */
    public function index()
    {
        return User::all();
    }

}
