<?php

namespace App\Services\JobSeeker;

use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\JobSeeker\JobSeekerRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class JobSeekerService implements JobSeekerServiceInterface
{

    private FileRepositoryInterface $fileRepositoryInterface;
    private JobSeekerRepositoryInterface $JobSeekerRepository;

    public function __construct(
        FileRepositoryInterface $fileRepositoryInterface,
        JobSeekerRepositoryInterface $JobSeekerRepositoryInterface
    ) {
        $this->fileRepositoryInterface = $fileRepositoryInterface;
        $this->JobSeekerRepository = $JobSeekerRepositoryInterface;
    }

    public function createProfile(array $data, UploadedFile|null $resume)
    {
        return DB::transaction(function () use ($data, $resume) {

            $user = request()->user();
            if ($this->JobSeekerRepository->show($user->id)) {
                throw ValidationException::withMessages([
                    'job_seeker' => ['User already has an job seeker profile.']
                ]);
            }

            $resumeFile = null;
            if ($resume) {
                $resumeFile = $this->fileRepositoryInterface->store($resume, $user->id, 'resume');
            }

            $formattedData = [
                'user_id' => $user->id,
                'bio' => $data['bio'],
                'portfolio' => $data['portfolio'],
                'current_job_title' => $data['current_job_title'],
                'resume_id' => $resumeFile?->id,
                'phone' => $data['phone'],
                'location' => $data['location'],
            ];

            return $this->JobSeekerRepository->createProfile($formattedData);
        });
    }

    public function updateProfile(array $data, int $jobSeekerId)
    {
        return $this->JobSeekerRepository->updateJobSeekerProfile($data, $jobSeekerId);
    }
}
