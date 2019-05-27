<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return response()->json(['status' => 'success'], 200);

    }

    public function login(Request $request) {

        $email = $request->json()->get('email');
        $password = $request->json()->get('password');

        if ($token = $this->guard()->attempt(['email' => $email, 'password' => $password])) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }

        return response()->json(['error' => 'Login failed.'], 401);
    }

    public function logout() {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out successfully.'
        ], 200);
    }

    public function user(Request $request) {
        $user = User::find(Auth::user()->id);
        return response()->json($user);
    }

    private function guard() {
        return Auth::guard();
    }

}
