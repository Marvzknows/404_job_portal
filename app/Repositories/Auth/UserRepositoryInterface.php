<?php

namespace App\Repositories\Auth;

interface UserRepositoryInterface
{
    public function findByEmail(string $email);

    public function register(array $data);

    public function getAuthenticatedUserWithProfile(int $userId);
}
