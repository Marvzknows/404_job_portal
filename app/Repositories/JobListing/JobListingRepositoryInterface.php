<?php

namespace App\Repositories\JobListing;

interface JobListingRepositoryInterface
{
    public function create(array $data);

    public function getPaginated(array $filters = [], int|null $employerId = null);
}
