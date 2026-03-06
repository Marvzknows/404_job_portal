<?php

namespace App\Services\SavedJob;

interface SavedJobServiceInterface
{
    public function listSavedJobs(array $fillable, int $userId);
    public function saveJob(int $userId, int $jobId): bool;
    public function unsaveJob(int $userId, int $jobId): bool;
}
