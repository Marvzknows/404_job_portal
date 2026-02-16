<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployerProfile;
use App\Http\Requests\UpdateEmployerProfileRequest;
use App\Http\Resources\ShowEmployerProfileResource;
use App\Services\Employer\EmployerServiceInterface;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    private EmployerServiceInterface $employerServiceInterface;

    public function __construct(EmployerServiceInterface $employerServiceInterface)
    {
        $this->employerServiceInterface = $employerServiceInterface;
    }
    public function store(StoreEmployerProfile $request)
    {
        $data = $request->validated();
        $logo = $request->file('logo');

        $data = $this->employerServiceInterface->createEmployerProfile($data, $request->user(), $logo);

        return response()->json([
            'success' => true,
            'message' => 'Employer profile created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $employerId)
    {
        $employer = $this->employerServiceInterface->showEmployerProfile($employerId);
        return response()->json([
            'success' => true,
            'data' => new ShowEmployerProfileResource($employer)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployerProfileRequest $request, string $employerId)
    {
        $validated = $request->validated();
        $this->employerServiceInterface->updateEmployerProfile($employerId, $validated);
        return response()->json([
            'success' => true,
            'message' => 'Employer profile updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return ['message' => 'REMOVE employer profile'];
    }

    public function updateLogo(Request $request, int $employerId)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $logo = $request->file('logo');
        $this->employerServiceInterface->updateEmployerLogo($employerId, $logo);

        return response()->json([
            'success' => true,
            'message' => 'Employer logo updated successfully'
        ], 200);
    }
}
