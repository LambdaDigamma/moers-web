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
    public function all()
    {
        return User::all();
    }

    /**
     * Returns the User for the given $id with its associated Groups.
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return User::where('id', $id)->with('groups')->first();
    }

}
