<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployerProfile;
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
    public function show(string $id)
    {
        return ['message' => 'VIEW employer profile'];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return ['message' => 'UPDATE employer profile'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return ['message' => 'REMOVE employer profile'];
    }
}
