<?php

namespace App\Services\JobApplication;

use Illuminate\Http\UploadedFile;

interface JobApplicationServiceInterface
{

    public function createJobApplication(array $data, UploadedFile $resume);
}
