<?php

namespace App\Repositories\Employer;

use App\Models\Employer;

class EmployerRepository implements EmployerRepositoryInterface
{

    public function findById(int $employerId)
    {
        return Employer::with('logo ', 'user')->find($employerId);
    }

    public function userHasProfile(int $userId)
    {
        return Employer::where('user_id', $userId)->exists();
    }

    public function create(array $data)
    {
        return Employer::create($data);
    }
}
