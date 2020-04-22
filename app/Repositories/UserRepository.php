<?php

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Models\User;

abstract class UserRepository
{
    public static function create(UserRequest $userRequest)
    {
        return User::create($userRequest->toArray());
    }

    public static function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
