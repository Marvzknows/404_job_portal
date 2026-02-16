<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use Illuminate\Http\Request;

class JobController extends Controller
{

    public function index()
    {
        //
    }

    public function store(StoreJobRequest $request)
    {
        $validated = $request->validated();
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
