<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register (UserRequest $userRequest)
    {
        if (!$userRequest->validated())
        {
            return response(['errors' => $userRequest->errors()->all()], 422);
        }

        $request['password'] = Hash::make($userRequest['password']);
        $user = User::create($userRequest->toArray());

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];

        return response($response, 200);
    }

    public function login (Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Pizza test token')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                return response(['errors' => 'Wrong password'], 422);
            }

        } else {
            return response(['errors' => 'User does not exist'], 422);
        }

    }

    public function logout (Request $request)
    {
        if (!$request->user()) {
            return response(['errors' => 'Unauthenticated'], 401);
        }

        $token = $request->user()->token();
        $token->revoke();

        return response(['message' => 'You have been succesfully logged out!'], 200);
    }
}
