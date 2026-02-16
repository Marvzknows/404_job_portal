<?php

namespace App\Services\JobListing;

use App\Repositories\JobListing\JobListingRepositoryInterface;
use App\Models\User;

class JobListingService implements JobListingServiceInterface
{
    protected $jobListingRepository;

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
}
