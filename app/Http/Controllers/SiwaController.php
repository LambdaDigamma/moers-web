<?php


namespace App\Http\Controllers;


use App\User;
use Auth;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use Request;

class SiwaController extends Controller
{

    public function login()
    {
        return Socialite::driver("sign-in-with-apple")
            ->scopes(["name", "email"])
            ->redirect();
    }

    public function callback(Request $request)
    {

        $appleUser = Socialite::driver("sign-in-with-apple")
            ->user();

        $user = User::where([
            ['provider_id', '=', $appleUser->getId()],
            ['provider', '=', 'apple']
        ])->first();

        if (!$user) {
            $user = User::create([
                'name' => $appleUser->getName(),
                'email' => $appleUser->getEmail(),
                'provider_id' => $appleUser->getId(),
                'provider' => 'apple'
            ]);
        }

        Auth::guard('web')->login($user, true);

        return redirect()->to(route('dashboard'));

    }

}