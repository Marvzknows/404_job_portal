<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\Auth\UserRepositoryInterface;

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

    public function getAuthenticatedUserWithProfile(int $userId)
    {
        return User::with(['employer.logo.uploadedBy', 'jobSeeker',])->find($userId);
    }

    public function updateUser(array $data, int $userId)
    {
        $user = User::findOrFail($userId);
        $user->update($data);
        return $user->fresh();
    }
}
