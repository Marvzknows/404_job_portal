<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\MeResource;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthServiceInterface $authServiceInterface;

    public function __construct(AuthServiceInterface $authServiceInterface)
    {
        $this->authServiceInterface = $authServiceInterface;
    }

    public function me(Request $request)
    {
        $data = $this->authServiceInterface->me($request->user());
        return response()->json([
            'success' => true,
            'data' => new MeResource($data),
        ]);
    }
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $this->authServiceInterface->register($validated);
        return response()->json(['message' => 'User registered successfully']);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $data = $this->authServiceInterface->login($validated);
        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'id' => $data['user']->id,
                'name' => $data['user']->name,
                'email' => $data['user']->email,
                'role' => $data['user']->role,
            ],
            'token' => $data['token'],
        ]);
    }

    public function logout(Request $request)
    {
        $this->authServiceInterface->logout($request->user());
        return response()->json(['message' => 'User logged out successfully']);
    }
}
