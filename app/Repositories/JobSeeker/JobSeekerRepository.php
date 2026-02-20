<?php

namespace App\Repositories\JobSeeker;

use App\Models\JobSeeker;
use App\Repositories\Base\BaseRepository;

class JobSeekerRepository extends BaseRepository implements JobSeekerRepositoryInterface
{

    public function __construct(JobSeeker $model)
    {
        parent::__construct($model);
    }
    public function show(int $userId): bool
    {
        return JobSeeker::where('user_id', $userId)->exists();
    }

    public function createProfile(array $data)
    {
        return $this->create($data);
    }

    public function showJobSeekerProfile(int $jobSeekerId)
    {
        return JobSeeker::with(['jobApplications', 'user.avatar', 'resume.uploadedBy'])->findOrFail($jobSeekerId);
    }
}
