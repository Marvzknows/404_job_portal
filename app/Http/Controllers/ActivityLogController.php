<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityLogResource;
use App\Services\ActivityLogs\ActivityLogServiceInterface;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    private ActivityLogServiceInterface $activityLogService;

    public function __construct(ActivityLogServiceInterface $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function list(Request $request)
    {
        $activityLogs = $this->activityLogService->getActivityLogs($request->query());
        return response()->json([
            'success' => true,
            'message' => 'Activity logs retrieved successfully',
            'data'    => ActivityLogResource::collection($activityLogs)->response()->getData()
        ]);
    }

    public function store(Request $request)
    {
        return 'create activity log';
    }

    public function show(string $id)
    {
        return 'show activity log';
    }

    public function update(Request $request, string $id)
    {
        return 'update activity log';
    }

    // public function destroy(string $id)
    // {
    //     //
    // }
}
