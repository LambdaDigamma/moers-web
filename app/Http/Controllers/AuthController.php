<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request) {

        $v = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed',
        ]);

        if ($v->fails()) {
            return response()->json($v->errors(), 422);
        }

        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];

        return response($response, 200);

    }

    public function login(Request $request) {

        $email = $request->json()->get('email');
        $password = $request->json()->get('password');



        $user = User::where('email', $email)->first();

        if ($user) {

            if (Hash::check($password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                return response($response, 200)->header('Authorization', $token);
            } else {
                $response = "Password missmatch";
                return response($response, 422);
            }

        } else {
            $response = 'User does not exist';
            return response($response, 422);
        }

    }

    public function logout(Request $request) {

        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response($response, 200);

    }

    public function user(Request $request) {
        $user = User::find(Auth::user()->id);
        return response()->json($user);
    }

    private function guard() {
        return Auth::guard();
    }

}
