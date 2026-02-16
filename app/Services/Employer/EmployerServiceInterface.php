<?php

namespace App\Services\Employer;

use App\Models\User;
use Illuminate\Http\UploadedFile;

interface EmployerServiceInterface
{

    public function createEmployerProfile(array $data, User $user, $logo = null);
    public function updateEmployerLogo(int $employerId, UploadedFile $logo);

    public function showEmployerProfile(int $employerId);
}
