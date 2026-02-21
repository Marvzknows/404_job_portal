<?php

namespace App\Repositories\JobApplication;

interface JobApplicationRepositoryInterface
{
    public function createJobApplication(array $data);
    public function findDuplicateApplication(int $jobSeekerId, int $jobListingId): bool;
}
