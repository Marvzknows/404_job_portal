<?php

namespace App\Repositories\ActivityLog;

interface ActivityLogRepositoryInterface
{
    public function getActivityLogs(array $filters, int $userId);
}
