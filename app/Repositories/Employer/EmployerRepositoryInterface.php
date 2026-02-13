<?php

namespace App\Repositories\Employer;

interface EmployerRepositoryInterface
{

    public function findById(int $employerId);

    public function userHasProfile(int $userId);

    public function create(array $data);
}
