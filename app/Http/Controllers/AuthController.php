<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Auth\AuthenticationException;
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

        $user = User::create($userRequest->toArray());
        $token = $user->createToken('Pizza test token')->accessToken;

        return response(['token' => $token], 200);
    }

    public function login (UserRequest $request)
    {
        if ($user = User::where('email', $request->email)->first()) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Pizza test token')->accessToken;

                return response(['token' => $token], 200);
            } else {
                return response(['errors' => 'Wrong password'], 422);
            }
        } else {
            return response(['errors' => 'User does not exist'], 404);
        }
    }

    /**
     * @param \App\Http\Requests\UserRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function logout (UserRequest $request)
    {
        if (!$request->user()) {
            throw new AuthenticationException();
        }

        $token = $request->user()->token();
        $token->revoke();

        return response(['message' => 'You have been succesfully logged out!'], 200);
    }
}
