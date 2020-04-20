<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register (Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $request['password']=Hash::make($request['password']);
        $user = User::create($request->toArray());

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];

        return response($response, 200);

    }

    public function login (Request $request) {

        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Pizza test token')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                return response(['errors'=> 'Wrong password'], 422);
            }

        } else {
            return response(['errors'=> 'User does not exist'], 422);
        }

    }

    public function logout (Request $request) {

        if (!$request->user()) {
            return response(['errors'=> 'Unauthenticated'], 401);
        }

        $token = $request->user()->token();
        $token->revoke();

        return response(['message'=> 'You have been succesfully logged out!'], 200);

    }
}
