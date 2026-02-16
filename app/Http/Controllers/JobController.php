<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Services\JobListing\JobListingServiceInterface;
use Illuminate\Http\Request;

class JobController extends Controller
{

    private JobListingServiceInterface $jobServiceInterface;

    public function __construct(JobListingServiceInterface $jobServiceInterface)
    {
        $this->jobServiceInterface = $jobServiceInterface;
    }
    public function index()
    {
        //
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
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function restore(string $id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Job restored successfully',
            'data' => [
                'id' => $id
            ]
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
