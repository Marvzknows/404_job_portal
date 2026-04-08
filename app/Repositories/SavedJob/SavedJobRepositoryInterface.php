<?php

namespace App\Repositories\SavedJob;

interface SavedJobRepositoryInterface
{
    public function listSavedJobs(array $filters, int $userId, int|null $jobSeekerId);
    public function saveJob(int $userId, int $jobId);
    public function unsaveJob(int $userId, int $jobId);
}
