<?php

namespace App\Services\SavedJob;

use App\Helpers\ActivityLogger;
use App\Models\SavedJob;
use App\Repositories\SavedJob\SavedJobRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SavedJobService implements SavedJobServiceInterface
{

    private SavedJobRepositoryInterface $savedJobRepository;

    public function __construct(SavedJobRepositoryInterface $savedJobRepository)
    {
        $this->savedJobRepository = $savedJobRepository;
    }

    public function listSavedJobs(array $filters, int $userId)
    {
        $user = request()->user();
        $jobSeekerId = $user && $user->jobSeeker ? $user->jobSeeker->id : null;

        return $this->savedJobRepository->listSavedJobs($filters, $userId, $jobSeekerId);
    }

    public function saveJob(int $userId, int $jobId)
    {
        return DB::transaction(function () use ($userId, $jobId) {
            if ($this->checkDuplicateSave($userId, $jobId)) {
                throw ValidationException::withMessages([
                    'saved_job' => ['Job is already saved.']
                ]);
            }
            $result = $this->savedJobRepository->saveJob($userId, $jobId);
            ActivityLogger::log($userId, 'SAVED_JOB', 'Saved a job', $jobId);
            return $result;
        });
    }

    public function unsaveJob(int $userId, int $jobId)
    {
        return DB::transaction(function () use ($userId, $jobId) {
            $result = $this->savedJobRepository->unsaveJob($userId, $jobId);
            ActivityLogger::log($userId, 'UNSAVED_JOB', 'Unsaved a job', $jobId);
            return $result;
        });
    }

    private function checkDuplicateSave(int $userId, int $jobId): bool
    {
        return SavedJob::where('user_id', $userId)->where('job_listing_id', $jobId)->exists();
    }
}
