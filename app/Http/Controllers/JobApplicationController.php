<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobApplicationRequest;
use App\Http\Requests\UpdateJobApplicationRequest;
use App\Http\Resources\JobApplicationListResource;
use App\Http\Resources\ShowJobApplicationResource;
use App\Repositories\JobApplication\JobApplicationRepositoryInterface;
use App\Services\JobApplication\JobApplicationServiceInterface;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{

    private JobApplicationServiceInterface $jobApplicationService;
    private JobApplicationRepositoryInterface $jobApplicationRepository;

    public function __construct(JobApplicationServiceInterface $jobApplicationService, JobApplicationRepositoryInterface $jobApplicationRepository)
    {
        $this->jobApplicationService = $jobApplicationService;
        $this->jobApplicationRepository = $jobApplicationRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'per_page', 'job_type', 'work_setup']);
        $user = $request->user();

        $jobApplications = $this->jobApplicationService->getJobApplicationList($filters, $user);

        return response()->json([
            'success' => true,
            'message' => 'Job applications retrieved successfully',
            'data'    => JobApplicationListResource::collection($jobApplications)->response()->getData()
        ]);
    }

    public function store(StoreJobApplicationRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('resume') && $request->file('resume')->isValid()) {
            $validated['resume'] = $request->file('resume');
        }

        $this->jobApplicationService->createJobApplication($validated);

        return response()->json([
            'success' => true,
            'message' => 'Job application created successfully',
        ]);
    }

    public function show(int $jobApplication, Request $request)
    {
        $user = $request->user();
        $application = $this->jobApplicationService->viewJobApplication($jobApplication, $user);
        return response()->json([
            'success' => true,
            'message' => 'Job application retrieved successfully',
            'data' => new ShowJobApplicationResource($application)
        ]);
    }

    public function update(UpdateJobApplicationRequest $request, int $jobApplicationId)
    {
        $validated = $request->validated();
        $resume = $request->file('resume');
        $this->jobApplicationService->updateJobApplication($jobApplicationId, $validated, $resume);
        return response()->json([
            'success' => true,
            'message' => 'Job application updated successfully',
        ]);
    }

    public function updateStatus(Request $request, int $jobApplicationId)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:viewed,shortlisted,accepted,rejected,withdrawn'
        ]);

        $this->jobApplicationService->updateJobApplicationStatus($jobApplicationId, $validated['status']);

        return response()->json([
            'success' => true,
            'message' => 'Job application status updated successfully',
        ]);
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
