<?php

namespace App\Services\JobApplication;

use App\Models\JobApplication;
use Illuminate\Http\UploadedFile;

interface JobApplicationServiceInterface
{

    public function createJobApplication(array $data, UploadedFile $resume);

    public function updateJobApplication(int $jobApplicationId, array $data, ?UploadedFile $resume);

    public function findJobApplicationById(int $jobApplicationId): JobApplication;
}
