<?php

namespace App\Repositories\SavedJob;

interface SavedJobRepositoryInterface
{
    public function listSavedJobs(array $filters, int $userId);
    public function saveJob(int $userId, int $jobId): bool;
    public function unsaveJob(int $userId, int $jobId): bool;
}
