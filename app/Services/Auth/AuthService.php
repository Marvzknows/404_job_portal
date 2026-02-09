<?php

namespace App\Services\Auth;

use App\Repositories\Auth\UserRepository;
use App\Repositories\Auth\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    private UserRepositoryInterface $userRepositoryInterface;
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }


    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepositoryInterface->register($data);
    }

    public function login(array $data) {}

    public function logout($user) {}
}
