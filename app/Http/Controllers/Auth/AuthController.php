<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // Validate and create a new user
        $validated = $request->validated();
        return response()->json(['message' => 'User registered successfully', 'user' => $validated]);
    }

    public function login(LoginRequest $request)
    {
        // Authenticate the user and return a token
        $validated = $request->validated();
        return response()->json(['message' => 'User logged in successfully', 'token' => 'sample_token', "payload" => $validated]);
    }

    public function logout(Request $request)
    {
        // Invalidate the user's token
        return response()->json(['message' => 'User logged out successfully']);
    }
}
