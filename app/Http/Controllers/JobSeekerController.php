<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobSeekerProfileRequest;
use App\Http\Requests\UpdateJobSeekerProfileResource;
use App\Http\Resources\JobSeekerProfileResource;
use App\Models\JobApplication;
use App\Models\SavedJob;
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

    public function updateResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:2048',
        ]);

        $jobSeekerId = $request->user()->jobSeeker->id ?? 0;

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

    public function deleteJobSeekerResume(Request $request, int $resumeId)
    {
        $user = $request->user();

        $this->jobSeekerServiceInterface->deleteResume($user->id, $resumeId);

        return response()->json([
            'success' => true,
            'message' => 'Resume deleted successfully',
        ], 200);
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

    public function dashboard(Request $request)
    {
        $user = $request->user();
        $jobSeekerId = $user->jobSeeker->id ?? null;

        if (!$user || !$jobSeekerId) {
            return response()->json([
                'total_applicants' => 0,
                'pending_review' => 0,
                'shortlisted_accepted' => 0,
                'saved_jobs' => 0,
            ]);
        }

        return response()->json([
            'total_applicants' => JobApplication::jobSeekerTotalApplication($jobSeekerId),
            'pending_review' => JobApplication::jobSeekerTotalStatusApplication($jobSeekerId, ['pending']),
            'shortlisted_accepted' => JobApplication::jobSeekerTotalStatusApplication($jobSeekerId, ['shortlisted']),
            'saved_jobs' => SavedJob::jobSeekerTotalApplication($user->id),
        ]);
    }
}
