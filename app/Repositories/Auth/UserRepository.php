<?php

namespace App\Repositories\Auth;

use App\Models\User;
use UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function register(array $data)
    {
        return User::create($data);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
