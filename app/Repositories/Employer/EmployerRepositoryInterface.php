<?php

namespace App\Repositories\Employer;

use App\Models\Employer;

interface EmployerRepositoryInterface
{

    public function findById(int $employerId): Employer;

    public function userHasProfile(int $userId);

    public function create(array $data);

    public function updateEmployerProfile(int $employerId, array $data): Employer;

    public function deleteEmployer(int $employerId);
}
