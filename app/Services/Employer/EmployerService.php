<?php

namespace App\Services\Employer;

use App\Models\User;

class EmployerService implements EmployerServiceInterface
{

    public function createEmployerProfile(array $data, User $user)
    {
        return 'test';
    }


    public function uploadEmployerAvatar()
    {
        return;
    }
}
