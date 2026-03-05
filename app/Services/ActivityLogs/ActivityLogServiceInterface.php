<?php

namespace App\Services\ActivityLogs;

interface ActivityLogServiceInterface
{
    public function getActivityLogs(array $filters);
    // public function createActivityLog(array $data): array;
    // public function updateActivityLog(int $id, array $data): array;
    // public function deleteActivityLog(int $id): bool;
}
