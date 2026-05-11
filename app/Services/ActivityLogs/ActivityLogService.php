<?php

namespace App\Services\ActivityLogs;

use App\Repositories\ActivityLog\ActivityLogRepositoryInterface;

class ActivityLogService implements ActivityLogServiceInterface
{

    public ActivityLogRepositoryInterface $activityLogRepository;

    public function __construct(ActivityLogRepositoryInterface $activityLogRepository)
    {
        $this->activityLogRepository = $activityLogRepository;
    }

    public function getActivityLogs(array $filters)
    {
        $user = request()->user();
        return $this->activityLogRepository->getActivityLogs($filters, $user->id);
    }
}
