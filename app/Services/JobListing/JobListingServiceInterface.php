<?php

namespace App\Services\JobListing;

use App\Models\User;

interface JobListingServiceInterface
{
    public function createJobListing(array $data, User $user);

    public function jobListingList(array $filters = []);
}
