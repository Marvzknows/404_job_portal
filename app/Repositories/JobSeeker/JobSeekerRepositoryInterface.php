<?php

namespace App\Repositories\JobSeeker;


interface JobSeekerRepositoryInterface
{
    public function show(int $userId): bool;
    public function createProfile(array $data);
}
