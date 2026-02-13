<?php

namespace App\Services\Employer;

use App\Models\User;

interface EmployerServiceInterface
{

    public function createEmployerProfile(array $data, User $user, $logo = null);
}
