<?php

namespace App\Services\SavedJob;

use App\Repositories\SavedJob\SavedJobRepositoryInterface;

class SavedJobService implements SavedJobServiceInterface
{

    private SavedJobRepositoryInterface $savedJobRepository;

    public function __construct(SavedJobRepositoryInterface $savedJobRepository)
    {
        $this->savedJobRepository = $savedJobRepository;
    }

    public function listSavedJobs(array $filters, int $userId)
    {
        return $this->savedJobRepository->listSavedJobs($filters, $userId);
    }

    public function saveJob(int $userId, int $jobId): bool
    {
        return true;
    }

    public function unsaveJob(int $userId, int $jobId): bool
    {
        return true;
    }
}
