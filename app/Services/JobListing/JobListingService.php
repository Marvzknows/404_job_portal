<?php

namespace App\Services\JobListing;

use App\Helpers\ActivityLogger;
use App\Repositories\JobListing\JobListingRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class JobListingService implements JobListingServiceInterface
{
    protected JobListingRepositoryInterface $jobListingRepository;

    public function __construct(JobListingRepositoryInterface $jobListingRepository)
    {
        $this->jobListingRepository = $jobListingRepository;
    }

    public function createJobListing(array $data, User $user)
    {
        return DB::transaction(function () use ($data, $user) {

            $data['employer_id'] = $user->employer->id;

            $job = $this->jobListingRepository->create($data);

            ActivityLogger::log(
                $user->id,
                'JOB_CREATED',
                "Created job {$data['title']}",
                $job->id,
                null
            );

            return $job;
        });
    }

    public function updateJobListing(array $data, int $jobId)
    {
        return DB::transaction(function () use ($data, $jobId) {
            $this->authorizeEmployerJob($jobId);
            $job = $this->jobListingRepository->update($data, $jobId);
            ActivityLogger::log(
                request()->user()->id,
                'JOB_UPDATED',
                "Updated job {$data['title']}",
                $job->id,
                null
            );
            return $job;
        });
    }

    public function jobListingList(array $filters = [], int | null $employerId = null)
    {
        // $user = request()->user();
        // $allowedSortColumns = ['created_at', 'title', 'salary_min', 'salary_max'];

        // if (!in_array($filters['sort_by'] ?? null, $allowedSortColumns)) {
        //     $filters['sort_by'] = 'created_at';
        // }


        // if ($user && $user->role === 'employer') {
        //     $employerId = $user->employer->id;
        // }

        return $this->jobListingRepository->getPaginated($filters, $employerId ?? null);
    }

    private function authorizeEmployerJob(int $jobId)
    {
        $user = request()->user();
        $employerId = $user->employer->id;

        $job = $this->jobListingRepository->show($jobId);

        if ($job->employer_id !== $employerId) {
            throw ValidationException::withMessages([
                'authorization' => ['You are not authorized to update this job listing.']
            ]);
        }

        return $job;
    }

    public function deleteJob(int $jobId)
    {
        return DB::transaction(function () use ($jobId) {

            $user = request()->user();

            $this->authorizeEmployerJob($jobId);

            $job = $this->jobListingRepository->show($jobId);

            $this->jobListingRepository->deleteJobListing($jobId);

            ActivityLogger::log(
                $user->id,
                'JOB_DELETED',
                "Deleted job {$job->title}",
                $job->id,
                null
            );

            return true;
        });
    }

    public function updateJobStatus(string $status, int $jobId)
    {
        return DB::transaction(function () use ($status, $jobId) {

            $user = request()->user();

            $job = $this->authorizeEmployerJob($jobId);

            $this->jobListingRepository->updateJobStatus($status, $jobId);

            ActivityLogger::log(
                $user->id,
                'JOB_UPDATED',
                "Updated job status of {$job->title} to {$status}",
                $job->id,
                null
            );

            return $job;
        });
    }
}
