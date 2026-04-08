<?php

namespace App\Repositories\JobListing;

use App\Models\JobListing;
use App\Repositories\Base\BaseRepository;

class JobListingRepository extends BaseRepository implements JobListingRepositoryInterface
{
    public function __construct(JobListing $model)
    {
        return parent::__construct($model);
    }
    public function create(array $data)
    {
        return JobListing::create($data);
    }

    public function update(array $data, int $jobId)
    {
        return JobListing::where('id', $jobId)->update($data);
    }

    public function getPaginated(array $filters = [], int|null $employerId = null, int|null $jobSeekerId = null)
    {
        $search         = $filters['search'] ?? null;
        $per_page       = $filters['per_page'] ?? 15;
        $sortBy         = $filters['sort_by'] ?? 'created_at';
        $sortDirection  = $filters['sort_dir'] ?? 'desc';
        $status         = $filters['status'] ?? 'open';
        $job_type       = $filters['job_type'] ?? null;
        $work_setup     = $filters['work_setup'] ?? null;
        $location       = $filters['location'] ?? null;

        return JobListing::query()
            ->with([
                'employer',
                'employer.logo',
                'employer.user',
                // Only load the application row that belongs to the current job seeker
                'jobApplications' => function ($q) use ($jobSeekerId) { // is_applied flag
                    $q->when($jobSeekerId, fn($q) => $q->where('job_seeker_id', $jobSeekerId));
                },
                'savedJobs' => function ($q) use ($jobSeekerId) {
                    $q->when($jobSeekerId, fn($q) => $q->where('user_id', $jobSeekerId));
                }
            ])
            ->withCount(['jobApplications as total_applicants'])
            ->when($employerId,  fn($q) => $q->where('employer_id', $employerId))
            ->when($search,      fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($location,    fn($q) => $q->where('location', 'like', "%{$location}%"))
            ->when($status,      fn($q) => $q->where('status', $status))
            ->when($job_type,    fn($q) => $q->where('job_type', $job_type))
            ->when($work_setup,  fn($q) => $q->where('work_setup', $work_setup))
            ->orderBy($sortBy, $sortDirection)
            ->paginate($per_page);
    }

    public function show(int $jobListingId): JobListing
    {
        return JobListing::with('employer', 'employer.logo', 'employer.user')->findOrFail($jobListingId);
    }

    public function deleteJobListing(int $jobId)
    {
        return $this->delete($jobId);
    }

    public function restoreJobListing(int $jobId)
    {
        return $this->restore($jobId);
    }

    public function updateJobStatus(string $status, int $jobId)
    {
        return JobListing::where('id', $jobId)->update(['status' => $status]);
    }
}
