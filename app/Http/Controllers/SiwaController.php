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

            $nameComponents = collect(explode(" ", $appleUser->getName()));

            $lastName = $nameComponents->slice($nameComponents->count() - 1)->first();
            $firstName = $nameComponents->slice(0, $nameComponents->count() - 1)->implode(" ");

            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $appleUser->getEmail(),
                'provider_id' => $appleUser->getId(),
                'provider' => 'apple'
            ]);
        }

        Auth::guard('web')->login($user, true);

        return redirect()->to(route('dashboard'));

    }

}