<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{

    public function details()
    {
        $user = Auth::user();
        return Inertia::render('Profile/Details', [
            'personalInformation' => [
                'name' => $user->name,
                'email' => $user->email,
                'canChangeEmail' => $user->provider_id !== null
            ]
        ]);
    }

}
