<?php

namespace App\Repositories\JobApplication;

use App\Models\JobApplication;
use App\Repositories\Base\BaseRepository;

class JobApplicationRepository extends BaseRepository implements JobApplicationRepositoryInterface
{


    public function __construct(JobApplication $model)
    {
        return parent::__construct($model);
    }
    public function findDuplicateApplication(int $jobSeekerId, int $jobListingId): bool
    {
        return JobApplication::where('job_seeker_id', $jobSeekerId)
            ->where('job_listing_id', $jobListingId)
            ->exists();
    }

    public function createJobApplication(array $data)
    {
        return $this->create($data);
    }

    public function findById(int $jobApplicationId): JobApplication
    {
        return JobApplication::with('jobSeeker', 'jobListing')->findOrFail($jobApplicationId);
    }

    public function updateJobApplication(int $jobApplicationId, array $data)
    {
        return JobApplication::where('id', $jobApplicationId)->update($data);
    }
}
