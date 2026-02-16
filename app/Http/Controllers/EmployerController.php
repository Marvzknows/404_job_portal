<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployerProfile;
use App\Http\Requests\UpdateEmployerProfileRequest;
use App\Http\Resources\ShowEmployerProfileResource;
use App\Repositories\Employer\EmployerRepositoryInterface;
use App\Services\Employer\EmployerServiceInterface;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    private EmployerServiceInterface $employerServiceInterface;
    private EmployerRepositoryInterface $employerRepositoryInterface;

    public function __construct(EmployerServiceInterface $employerServiceInterface, EmployerRepositoryInterface $employerRepositoryInterface)
    {
        $this->employerServiceInterface = $employerServiceInterface;
        $this->employerRepositoryInterface = $employerRepositoryInterface;
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

    public function show(string $employerId)
    {
        $employer = $this->employerServiceInterface->showEmployerProfile($employerId);
        return response()->json([
            'success' => true,
            'data' => new ShowEmployerProfileResource($employer)
        ]);
    }

    public function update(UpdateEmployerProfileRequest $request, string $employerId)
    {
        $validated = $request->validated();
        $this->employerServiceInterface->updateEmployerProfile($employerId, $validated);
        return response()->json([
            'success' => true,
            'message' => 'Employer profile updated successfully'
        ]);
    }

    public function destroy(string $employerId)
    {
        $this->employerRepositoryInterface->deleteEmployer($employerId);
        return response()->json([
            'success' => true,
            'message' => 'Employer profile deleted successfully'
        ]);
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

    public function restore(string $employerId)
    {
        $this->employerRepositoryInterface->restoreEmployer($employerId);
        return response()->json([
            'success' => true,
            'message' => 'Employer profile restored successfully'
        ]);
    }
}
