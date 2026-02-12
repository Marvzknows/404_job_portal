<?php

namespace App\Services\Auth;

use App\Repositories\Auth\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

    public function login(array $data)
    {
        $user = $this->userRepositoryInterface->findByEmail($data['email']);
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.']
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout($user)
    {
        try {
            $user->tokens()->delete();
        } catch (\Exception $e) {
            return false;
        }
    }
}
