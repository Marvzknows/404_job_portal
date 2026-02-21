<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobSeekerProfileRequest;
use App\Http\Requests\UpdateJobSeekerProfileResource;
use App\Http\Resources\JobSeekerProfileResource;
use App\Repositories\JobSeeker\JobSeekerRepositoryInterface;
use App\Services\JobSeeker\JobSeekerServiceInterface;
use Illuminate\Http\Request;

class JobSeekerController extends Controller
{

    private JobSeekerServiceInterface $jobSeekerServiceInterface;
    private JobSeekerRepositoryInterface $jobseekerRepository;
    public function __construct(
        JobSeekerServiceInterface $jobSeekerServiceInterface,
        JobSeekerRepositoryInterface $jobseekerRepository
    ) {
        $this->jobSeekerServiceInterface = $jobSeekerServiceInterface;
        $this->jobseekerRepository = $jobseekerRepository;
    }
    public function store(StoreJobSeekerProfileRequest $request)
    {
        $validated = $request->validated();
        $resume = $request->file('resume') ?? null;
        $this->jobSeekerServiceInterface->createProfile($validated, $resume);
        return response()->json([
            'success' => true,
            'message' => 'Job seeker profile created successfully',
        ]);
    }

    public function show(int $id)
    {
        $jobSeekerProfile = $this->jobseekerRepository->showJobSeekerProfile($id);
        return response()->json([
            'success' => true,
            'data' => new JobSeekerProfileResource($jobSeekerProfile),
        ]);
    }

    public function updateResume(Request $request, int $jobSeekerId)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:2048',
        ]);

        $resume = $request->file('resume');
        $this->jobSeekerServiceInterface->updateResume($resume, $jobSeekerId);
        return response()->json([
            'success' => true,
            'message' => 'Job seeker resume updated successfully'
        ]);
    }

    public function update(UpdateJobSeekerProfileResource $request, int $id)
    {
        $validated = $request->validated();
        $this->jobSeekerServiceInterface->updateProfile($validated, $id);
        return response()->json([
            'success' => true,
            'message' => 'Job seeker profile updated successfully',
        ]);
    }

    public function destroy(string $id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Job seeker profile deleted successfully',
        ]);
    }

    public function restore(string $id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Job seeker profile restored successfully',
        ]);
    }
}
