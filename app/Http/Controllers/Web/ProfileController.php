<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;
use Spatie\PersonalDataExport\Jobs\CreatePersonalDataExportJob;

class ProfileController extends Controller
{

    public function details()
    {
        $user = Auth::user();
        return Inertia::render('Profile/Details', [
            'personalInformation' => [
                'name' => $user->name,
                'email' => $user->email,
                'description' => $user->description,
                'canChangeEmail' => $user->provider_id !== null
            ]
        ]);
    }

    public function deleteAccount()
    {

    }

    public function exportData() {

        $user = Auth::user();

        dispatch(new CreatePersonalDataExportJob($user));

        return Redirect::to(route('profile'))->with('success', 'Deine Daten wurden exportiert und dir per Mail zugeschickt.');

    }

}
