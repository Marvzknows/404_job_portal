<?php

namespace App\Services\JobSeeker;

use Illuminate\Http\UploadedFile;

interface JobSeekerServiceInterface
{

    public function createProfile(array $data, UploadedFile|null $resume);

    public function updateProfile(array $data, int $jobSeekerId);
}
