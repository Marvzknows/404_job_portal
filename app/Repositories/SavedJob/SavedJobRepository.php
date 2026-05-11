<?php

namespace App\Repositories\SavedJob;

use App\Models\SavedJob;

class SavedJobRepository implements SavedJobRepositoryInterface
{
    public function listSavedJobs(array $filters, int $userId, $jobSeekerId)
    {
        $search = $filters['search'] ?? null;
        $dateFrom = $filters['date_from'] ?? null;
        $dateTo = $filters['date_to'] ?? null;
        $perPage = min((int) ($filters['per_page'] ?? 15), 100);

        return SavedJob::query()
            ->with([
                // 'jobListing.employer',
                'jobListing.employer.logo',
                'jobListing.jobApplications' => function ($q) use ($jobSeekerId) {
                    $q->where('job_seeker_id', $jobSeekerId);
                }
            ])
            ->whereHas('jobListing') // exclude soft-deleted listings
            ->where('user_id', $userId)
            ->when($search, function ($query) use ($search) {
                $query->whereHas('jobListing', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            })
            ->when($dateFrom, fn($q) => $q->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->whereDate('created_at', '<=', $dateTo))
            ->paginate($perPage);
    }

    public function saveJob(int $userId, int $jobId)
    {
        return SavedJob::create([
            'user_id' => $userId,
            'job_listing_id' => $jobId,
        ]);
    }

    public function unsaveJob(int $userId, int $jobId)
    {
        return SavedJob::where('user_id', $userId)
            ->where('job_listing_id', $jobId)
            ->delete();
    }
}
