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
        return JobApplication::with('jobSeeker.user', 'jobListing.employer')->findOrFail($jobApplicationId);
    }

    public function updateJobApplication(int $jobApplicationId, array $data)
    {
        return JobApplication::where('id', $jobApplicationId)->update($data);
    }

    public function getEmployerJobApplicationList(array $filters, int $employerId)
    {
        $perPage = $filters['per_page'] ?? 15;

        $query = JobApplication::with(['jobSeeker.user', 'jobListing'])
            ->whereHas(
                'jobListing',
                fn($q) =>
                $q->where('employer_id', $employerId)
            );

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $query->whereHas('jobListing', function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->paginate($perPage);
    }

    public function getJobSeekerJobApplicationList(array $filters, int $jobSeekerId)
    {
        $perPage = $filters['per_page'] ?? 15;

        $query = JobApplication::with(['jobSeeker.user', 'jobListing'])
            ->where('job_seeker_id', $jobSeekerId);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $query->whereHas('jobListing', function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->paginate($perPage);
    }
    public function getAllJobApplications(array $filters)
    {
        $perPage = $filters['per_page'] ?? 15;

        $query = JobApplication::with(['jobSeeker.user', 'jobListing']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $query->whereHas('jobListing', function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->paginate($perPage);
    }
}
