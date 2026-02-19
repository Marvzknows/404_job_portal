<?php

namespace App\Services\Auth;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data);

    public function login(array $data);

    public function logout(User $user);

    public function me(User $user);
}
