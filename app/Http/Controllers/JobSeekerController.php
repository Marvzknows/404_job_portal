<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobSeekerController extends Controller
{
    public function store(Request $request)
    {
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
