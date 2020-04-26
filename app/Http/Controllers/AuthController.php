<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register (UserRequest $userRequest)
    {
        if (!$userRequest->validated()) {
            return response(['errors' => $userRequest->errors()->all()], 422);
        }

        $user = UserRepository::create($userRequest);
        $token = $user->createToken('Pizza test token')->accessToken;

        return response(['token' => $token], 200);
    }

    public function login (Request $request)
    {
        if ($user = UserRepository::findByEmail($request->email)) {
            if ($request->password === $user->password) {
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
     * @param $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function logout (Request $request)
    {
        if (!$request->user()) {
            throw new AuthenticationException();
        }

        $token = $request->user()->token();
        $token->revoke();

        return response(['message' => 'You have been successfully logged out!'], 200);
    }
}
