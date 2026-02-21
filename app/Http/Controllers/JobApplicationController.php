<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobApplicationRequest;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{

    public function index()
    {
        return 'job application paginated list';
    }

    public function store(StoreJobApplicationRequest $request)
    {
        $validated = $request->validated();
        $resume = $request->file('resume');

        return response()->json([
            'success' => true,
            'message' => 'Job application created successfully',
        ]);
    }

    public function show(string $id)
    {
        return 'show';
    }

    public function update(Request $request, string $id)
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
