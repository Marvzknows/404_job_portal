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
                "first_name" => $data['user']->first_name,
                "last_name" => $data['user']->last_name,
                'full_name' => $data['user']->first_name . ' ' . $data['user']->last_name,
                'email' => $data['user']->email,
                'role' => $data['user']->role,
                'avatar' => $data['user']->avatar ?? null,
            ],
            'token' => $data['token'],
        ]);
    }

    public function logout(Request $request)
    {
        $this->authServiceInterface->logout($request->user());
        return response()->json(['message' => 'User logged out successfully']);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $avatar = $request->file('avatar');
        $this->authServiceInterface->updateAvatar($avatar, $request->user());

        return response()->json([
            'success' => true,
            'message' => 'User avatar updated successfully'
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);

        $this->authServiceInterface->changePassword($validated, $request->user());

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully'
        ], 200);
    }
}
