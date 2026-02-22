<?php

namespace App\Repositories\JobApplication;

use App\Models\JobApplication;

interface JobApplicationRepositoryInterface
{
    public function createJobApplication(array $data);
    public function findDuplicateApplication(int $jobSeekerId, int $jobListingId): bool;

    public function findById(int $jobApplicationId): JobApplication;

    public function updateJobApplication(int $jobApplicationId, array $data);

    public function getJobSeekerJobApplicationList(array $filters, int $jobSeekerId);

    public function getEmployerJobApplicationList(array $filters, int $employerId);

    public function getAllJobApplications(array $filters);
}
