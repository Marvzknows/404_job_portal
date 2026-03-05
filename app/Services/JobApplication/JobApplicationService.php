<?php

namespace App\Services\JobApplication;

use App\Helpers\ActivityLogger;
use App\Models\JobApplication;
use App\Models\User;
use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\JobApplication\JobApplicationRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class JobApplicationService implements JobApplicationServiceInterface
{

    private FileRepositoryInterface $fileRepository;
    private JobApplicationRepositoryInterface $jobApplicationRepository;

    public function __construct(FileRepositoryInterface $fileRepository, JobApplicationRepositoryInterface $jobApplicationRepository)
    {
        $this->fileRepository = $fileRepository;
        $this->jobApplicationRepository = $jobApplicationRepository;
    }

    public function createJobApplication(array $data, UploadedFile $resume)
    {
        return DB::transaction(function () use ($data, $resume) {

            $user = request()->user();
            if (!$user->jobSeeker) {
                throw ValidationException::withMessages([
                    'job_listing_id' => ['You dont have a job seeker profile.']
                ]);
            }

            if ($this->jobApplicationRepository->findDuplicateApplication($user->jobSeeker->id, $data['job_listing_id'])) {
                throw ValidationException::withMessages([
                    'job_listing_id' => ['You have already applied for this job.']
                ]);
            }

            $resumeFile = $this->fileRepository->store($resume, $user->id, 'resume');

            return $this->jobApplicationRepository->createJobApplication([
                'job_seeker_id' => $user->jobSeeker->id,
                'job_listing_id' => $data['job_listing_id'],
                'cover_letter' => $data['cover_letter'] ?? null,
                'resume_id' => $resumeFile->id,
            ]);
        });
    }

    public function updateJobApplication(int $jobApplicationId, array $data, ?UploadedFile $resume)
    {
        return DB::transaction(function () use ($jobApplicationId, $data, $resume) {

            $user = request()->user();

            $jobApplication = $this->findJobApplicationById($jobApplicationId);

            if ($jobApplication->job_seeker_id !== $user->jobSeeker->id) {
                throw ValidationException::withMessages([
                    'job_application' => ['You are not authorized to update this job application.']
                ]);
            }

            $updateData = collect($data)->except('resume')->toArray();

            if ($resume) {
                $resumeFile = $this->fileRepository->store($resume, $user->id, 'resume');
                $updateData['resume_id'] = $resumeFile->id;
            }

            return $this->jobApplicationRepository->updateJobApplication(
                $jobApplicationId,
                $updateData
            );
        });
    }

    public function findJobApplicationById(int $jobApplicationId): JobApplication
    {
        return $this->jobApplicationRepository->findById($jobApplicationId);
    }

    public function getJobApplicationList(array $filters, User $user)
    {
        if ($user->isEmployer()) {
            return $this->jobApplicationRepository->getEmployerJobApplicationList($filters, $user->employer->id);
        }

        if ($user->isJobSeeker()) {
            return $this->jobApplicationRepository->getJobSeekerJobApplicationList($filters, $user->jobSeeker->id);
        }

        return $this->jobApplicationRepository->getAllJobApplications($filters);
    }

    public function updateJobApplicationStatus(int $jobApplicationId, string $status)
    {
        return DB::transaction(function () use ($status, $jobApplicationId) {

            $user = request()->user();
            $jobApplication = $this->findJobApplicationById($jobApplicationId);

            if ($user->isEmployer()) {

                if (!in_array($status, ['viewed', 'shortlisted', 'accepted', 'rejected'])) {
                    throw ValidationException::withMessages([
                        'status' => ['Invalid status for employer']
                    ]);
                }

                if ($jobApplication->jobListing->employer_id !== $user->employer->id) {
                    throw ValidationException::withMessages([
                        'job_application' => ['You are not authorized to update this job application.']
                    ]);
                }
            }

            if ($user->isJobSeeker()) {

                if (!in_array($status, ['withdrawn'])) {
                    throw ValidationException::withMessages([
                        'status' => ['Invalid status for job seeker']
                    ]);
                }

                if ($jobApplication->job_seeker_id !== $user->jobSeeker->id) {
                    throw ValidationException::withMessages([
                        'job_application' => ['You are not authorized to update this job application.']
                    ]);
                }
            }

            // update first
            $this->jobApplicationRepository->updateJobApplicationStatus($jobApplicationId, $status);

            $activityLogStatus = $this->applicationStatusParser($status);

            ActivityLogger::log(
                $user->id,
                $activityLogStatus,
                "Updated job application status to {$status}",
                null,
                $jobApplication->id
            );

            return $jobApplication;
        });
    }

    private function applicationStatusParser(string $status)
    {
        $validStatuses = ['viewed', 'shortlisted', 'accepted', 'rejected', 'withdrawn'];
        $convertedAction = [
            'viewed' => 'JOB_VIEWED',
            'shortlisted' => 'JOB_SHORTLISTED',
            'accepted' => 'JOB_ACCEPTED',
            'rejected' => 'JOB_REJECTED',
            'withdrawn' => 'APPLICATION_WITHDRAWN',
        ];

        if (!in_array($status, $validStatuses)) {
            throw ValidationException::withMessages([
                'status' => ['Invalid job application status']
            ]);
        }
        return $convertedAction[$status] ?? $status;
    }

    public function viewJobApplication(int $jobApplicationId, User $user): JobApplication
    {
        return DB::transaction(function () use ($jobApplicationId, $user) {
            $jobApplication = $this->findJobApplicationById($jobApplicationId);

            if ($user->isEmployer() && $jobApplication->status === 'pending') {
                ActivityLogger::log($user->id, 'JOB_VIEWED', 'Viewed job application', null, $jobApplicationId);
            }

            return $jobApplication;
        });
    }
}
