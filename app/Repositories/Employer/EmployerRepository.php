<?php

namespace App\Repositories\Employer;

use App\Models\Employer;

class EmployerRepository implements EmployerRepositoryInterface
{

    public function findById(int $employerId): Employer
    {
        return Employer::with('logo', 'user', 'jobListings')->findOrFail($employerId);
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
