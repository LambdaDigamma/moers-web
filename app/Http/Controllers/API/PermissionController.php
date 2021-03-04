<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Bouncer;

class PermissionController extends Controller
{
    public function allRoles()
    {
        return Bouncer::role()->all();
    }

    public function roles(User $user)
    {
        return $user->roles();
    }
}
