<?php

namespace App\Repositories\JobListing;

use App\Models\JobListing;

interface JobListingRepositoryInterface
{
    public function create(array $data);

    public function getPaginated(array $filters = [], int|null $employerId = null);

    public function show(int $jobListingId): JobListing;

    public function update(array $data, int $jobId);
}
