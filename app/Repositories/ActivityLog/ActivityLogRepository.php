<?php

namespace App\Repositories\ActivityLog;

use App\Models\ActivityLog;

class ActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function getActivityLogs(array $filters = [], int $userId)
    {
        $action = $filters['action'] ?? null;

        $dateFrom = $filters['date_from'] ?? null;
        $dateTo = $filters['date_to'] ?? null;

        $per_page = $filters['per_page'] ?? 15;
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_dir'] ?? 'desc';

        return ActivityLog::query()
            ->with('user', 'jobListing', 'jobApplication', 'jobApplication.jobListing')

            ->where('user_id', $userId)

            ->when($action, function ($q) use ($action) {
                $q->where('action', $action);
            })

            ->when($dateFrom && $dateTo, function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })

            ->when($dateFrom && !$dateTo, function ($q) use ($dateFrom) {
                $q->whereDate('created_at', '>=', $dateFrom);
            })

            ->when(!$dateFrom && $dateTo, function ($q) use ($dateTo) {
                $q->whereDate('created_at', '<=', $dateTo);
            })

            ->orderBy($sortBy, $sortDirection)

            ->paginate($per_page);
    }
}
