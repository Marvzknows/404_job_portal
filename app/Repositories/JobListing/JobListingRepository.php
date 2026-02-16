<?php

namespace App\Repositories\JobListing;

use App\Models\JobListing;

class JobListingRepository implements JobListingRepositoryInterface
{
    public function create(array $data)
    {
        return JobListing::create($data);
    }
}
