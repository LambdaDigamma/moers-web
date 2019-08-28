<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Bouncer;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function allRoles() {
        return Bouncer::role()->all();
    }

    public function roles(User $user)
    {
        return $user->roles();
    }

}
