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

        $query = JobApplication::with(['jobSeeker.user', 'jobSeeker.user.avatar', 'jobListing'])
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
        $perPage    = $filters['per_page'] ?? 15;
        $status     = $filters['status'] ?? null;
        $search     = $filters['search'] ?? null;
        $job_type   = $filters['job_type'] ?? null;
        $work_setup = $filters['work_setup'] ?? null;

        return JobApplication::with([
            'jobSeeker.user',
            'jobListing',
            'jobListing.employer',
            'jobListing.employer.logo'
        ])
            ->where('job_seeker_id', $jobSeekerId)
            ->when($status, fn($q) => $q->where('status', $status))
            ->when(
                $search,
                fn($q) =>
                $q->whereHas('jobListing', fn($q2) => $q2->where('title', 'like', "%{$search}%"))
            )
            ->when(
                $job_type,
                fn($q) =>
                $q->whereHas('jobListing', fn($q2) => $q2->where('job_type', $job_type))
            )
            ->when(
                $work_setup,
                fn($q) =>
                $q->whereHas('jobListing', fn($q2) => $q2->where('work_setup', $work_setup))
            )
            ->latest()
            ->paginate($perPage);
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

    public function updateJobApplicationStatus(int $jobApplicationId, string $status)
    {
        return JobApplication::where('id', $jobApplicationId)->update(['status' => $status]);
    }
}
