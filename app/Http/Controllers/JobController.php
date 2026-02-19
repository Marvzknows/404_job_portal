<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Http\Resources\ShowJobListingListResource;
use App\Repositories\JobListing\JobListingRepositoryInterface;
use App\Services\JobListing\JobListingServiceInterface;
use Illuminate\Http\Request;

class JobController extends Controller
{

    private JobListingServiceInterface $jobServiceInterface;
    private JobListingRepositoryInterface $JobListingRepositoryInterface;

    public function __construct(
        JobListingServiceInterface $jobServiceInterface,
        JobListingRepositoryInterface $JobListingRepositoryInterface
    ) {
        $this->jobServiceInterface = $jobServiceInterface;
        $this->JobListingRepositoryInterface = $JobListingRepositoryInterface;
    }
    public function index(Request $request)
    {
        $data = $this->jobServiceInterface->jobListingList($request->query());
        return response()->json([
            'success' => true,
            'message' => 'Job listings retrieved successfully',
            'data'    => ShowJobListingListResource::collection($data)->response()->getData()
        ]);
    }

    public function store(StoreJobRequest $request)
    {
        $validated = $request->validated();
        $this->jobServiceInterface->createJobListing($validated, $request->user());
        return response()->json([
            'success' => true,
            'message' => 'Job created successfully',
            'data' => $validated
        ]);
    }

    public function show(string $id)
    {
        $data = $this->JobListingRepositoryInterface->show($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function update(UpdateJobRequest $request, int $id)
    {
        $validated = $request->validated();
        $this->jobServiceInterface->updateJobListing($validated, $id);
        return response()->json([
            'success' => true,
            'message' => 'Job updated successfully',
        ]);
    }

    public function destroy(int $id)
    {
        $this->jobServiceInterface->deleteJob($id);
        return response()->json([
            'success' => true,
            'message' => 'Job listing deleted successfully',
        ]);
    }

    public function restore(int $id)
    {
        $this->JobListingRepositoryInterface->restoreJobListing($id);
        return response()->json([
            'success' => true,
            'message' => 'Job restored successfully',
        ]);
    }

    public function status(Request $request, string $id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Job status updated successfully',
            'data' => [
                'id' => $id,
                'status' => $request->input('status')
            ]
        ]);
    }
}
