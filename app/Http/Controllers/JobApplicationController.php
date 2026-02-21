<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobApplicationRequest;
use App\Http\Requests\UpdateJobApplicationRequest;
use App\Services\JobApplication\JobApplicationServiceInterface;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{

    private JobApplicationServiceInterface $jobApplicationService;

    public function __construct(JobApplicationServiceInterface $jobApplicationService)
    {
        $this->jobApplicationService = $jobApplicationService;
    }

    public function index()
    {
        return 'job application paginated list';
    }

    public function store(StoreJobApplicationRequest $request)
    {
        $validated = $request->validated();
        $resume = $request->file('resume');

        $this->jobApplicationService->createJobApplication($validated, $resume ?? null);

        return response()->json([
            'success' => true,
            'message' => 'Job application created successfully',
        ]);
    }

    public function show(string $id)
    {
        return 'show';
    }

    public function update(UpdateJobApplicationRequest $request, int $id)
    {
        return 'update job application';
    }

    public function updateStatus(Request $request, int $jobApplicationId)
    {
        return 'update application status';
    }

    public function destroy(string $id)
    {
        return 'delete job application';
    }

    public function restore(int $id)
    {
        return 'restore deleted job application';
    }
}
