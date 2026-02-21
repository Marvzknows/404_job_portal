<?php

namespace App\Services\JobApplication;

use App\Models\JobApplication;
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
}
