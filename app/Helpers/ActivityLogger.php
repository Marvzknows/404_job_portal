<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger
{

    public static function log(
        int $userId,
        string $action,
        string $description,
        ?int $jobListingId = null,
        ?int $jobApplicationId = null,
    ) {
        return ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'job_listing_id' => $jobListingId,
            'job_application_id' => $jobApplicationId,
        ]);
    }
}
