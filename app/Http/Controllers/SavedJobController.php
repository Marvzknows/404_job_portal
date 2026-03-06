<?php

namespace App\Http\Controllers;

use App\Services\SavedJob\SavedJobServiceInterface;
use Illuminate\Http\Request;

class SavedJobController extends Controller
{

    private SavedJobServiceInterface $savedJobService;

    public function __construct(SavedJobServiceInterface $savedJobService)
    {
        $this->savedJobService = $savedJobService;
    }

    public function list(Request $request)
    {
        $filters = $request->only(['search', 'per_page', 'date_to', 'date_from']);
        $user = $request->user();

        $savedJobs = $this->savedJobService->listSavedJobs($filters, $user->id);

        return response()->json([
            'success' => true,
            'message' => 'Saved Job retrieved successfully',
            'data'    => $savedJobs
        ]);
    }

    public function store(Request $request)
    {
        return 'store';
    }

    // public function show(string $id)
    // {
    //     return 'show';
    // }

    public function destroy(string $id)
    {
        return 'destroy';
    }
}
