<?php

namespace App\Services\JobApplication;

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
}
