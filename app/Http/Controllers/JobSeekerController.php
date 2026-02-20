<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobSeekerProfileRequest;
use App\Services\JobSeeker\JobSeekerServiceInterface;
use Illuminate\Http\Request;

class JobSeekerController extends Controller
{

    private JobSeekerServiceInterface $jobSeekerServiceInterface;
    public function __construct(JobSeekerServiceInterface $jobSeekerServiceInterface)
    {
        $this->jobSeekerServiceInterface = $jobSeekerServiceInterface;
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

    public function show(string $id)
    {
        return response()->json([
            'success' => true,
            'data' => 'job seeker profile data',
        ]);
    }

    public function updateResume(Request $request, int $jobSeekerId)
    {
        return response()->json([
            'success' => true,
            'message' => 'Job seeker resume updated successfully'
        ]);
    }

    public function update(Request $request, string $id)
    {
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
