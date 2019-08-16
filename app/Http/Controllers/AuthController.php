<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
     * @param Request $request
     * @return ResponseFactory|JsonResponse|Response
     */
    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
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

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $email = $request->json()->get('email');
        $password = $request->json()->get('password');

        $user = User::where('email', $email)->first();

        if ($user) {

            if (Hash::check($password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return response(['token' => $token], 200)->header('Authorization', $token);
            } else {
                return $this->errorResponse('Password mismatch', 422);
            }

        } else {
            return $this->errorResponse('User does not exist', 422);
        }

    }

    public function logout(Request $request) {

        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been successfully logged out!';
        return response($response, 200);

    }

    public function user(Request $request) {

        $user = $request->user();

        $user->roles = $user->getRoles();
        $user->abilities = $user->getAbilities();
        $user->groups = $user->groups()->get();

        return response()->json($user);

    }

    private function guard() {
        return Auth::guard();
    }

    private function errorResponse($message, $status) {
        return response(['errors' => ['common' => [$message]]], $status);
    }

}
