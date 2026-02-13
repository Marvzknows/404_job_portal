<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployerProfile;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployerProfile $request)
    {
        $data = $request->validated();
        return ['message' => $data];
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
