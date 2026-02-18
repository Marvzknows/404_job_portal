<?php

namespace App\Repositories\JobListing;

use App\Models\JobListing;

class JobListingRepository implements JobListingRepositoryInterface
{
    public function create(array $data)
    {
        return JobListing::create($data);
    }

    public function getPaginated(array $filters = [], int|null $employerId = null)
    {
        $search = $filters['search'] ?? null;
        $per_page = $filters['per_page'] ?? 15;
        $sortBy   = $filters['sort_by'] ?? 'created_at';
        $sortDirection  = $filters['sort_dir'] ?? 'desc';
        $status = $filters['status'] ?? 'open';
        $job_type = $filters['job_type'] ?? null;

        return JobListing::query()
            ->with('employer', 'employer.logo', 'employer.user')
            ->when($employerId, function ($q) use ($employerId) {
                $q->where('employer_id', $employerId);
            })->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })->when($job_type, function ($q) use ($job_type) {
                $q->where('job_type', $job_type);
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($per_page);
    }
}
