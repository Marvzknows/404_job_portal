<?php

namespace App\Services\JobApplication;

use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\UploadedFile;

interface JobApplicationServiceInterface
{

    public function getJobApplicationList(array $filters, User $user);
    public function createJobApplication(array $data, UploadedFile $resume);

    public function updateJobApplication(int $jobApplicationId, array $data, ?UploadedFile $resume);

    public function findJobApplicationById(int $jobApplicationId): JobApplication;

    public function updateJobApplicationStatus(int $jobApplicationId, string $status);

    public function viewJobApplication(int $jobApplicationId, User $user): JobApplication;
}
