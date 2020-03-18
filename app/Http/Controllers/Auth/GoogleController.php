<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Laravel\Socialite\Facades\Socialite;
use Request;

class GoogleController extends Controller
{

    public function login()
    {
        return Socialite::driver("google")
            ->scopes(["name", "email"])
            ->redirect();
    }

    public function callback(Request $request)
    {

        $googleUser = Socialite::driver("google")
            ->user();

        $user = User::where([
            ['provider_id', '=', $googleUser->getId()],
            ['provider', '=', 'apple']
        ])->first();

        if (!$user) {

            $nameComponents = collect(explode(" ", $googleUser->getName()));

            $lastName = $nameComponents->slice($nameComponents->count() - 1)->first();
            $firstName = $nameComponents->slice(0, $nameComponents->count() - 1)->implode(" ");

            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $googleUser->getEmail(),
                'provider_id' => $googleUser->getId(),
                'provider' => 'apple'
            ]);
        }

        Auth::guard('web')->login($user, true);

        return redirect()->to(route('dashboard'));

    }

}