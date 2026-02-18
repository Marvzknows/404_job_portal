<?php

namespace App\Services\JobListing;

use App\Repositories\JobListing\JobListingRepositoryInterface;
use App\Models\User;

class JobListingService implements JobListingServiceInterface
{
    protected JobListingRepositoryInterface $jobListingRepository;

    public function __construct(JobListingRepositoryInterface $jobListingRepository)
    {
        $this->jobListingRepository = $jobListingRepository;
    }

    public function createJobListing(array $data, User $user)
    {
        // Attach user info if needed
        $data['employer_id'] = $user->employer->id;
        return $this->jobListingRepository->create($data);
    }

    public function jobListingList(array $filters = [])
    {
        $user = request()->user();
        $employerId = null;
        // $allowedSortColumns = ['created_at', 'title', 'salary_min', 'salary_max'];

        // if (!in_array($filters['sort_by'] ?? null, $allowedSortColumns)) {
        //     $filters['sort_by'] = 'created_at';
        // }


        if ($user->role !== 'admin') {
            $employerId = $user->employer->id;
        }

        return $this->jobListingRepository->getPaginated($filters, $employerId ?? null);
    }
}
