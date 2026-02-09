<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate and create a new user
        return response()->json(['message' => 'User registered successfully', 'user' => $request->all()]);
    }

    public function login(Request $request)
    {
        // Authenticate the user and return a token
        return response()->json(['message' => 'User logged in successfully', 'token' => 'sample_token']);
    }

    public function logout(Request $request)
    {
        // Invalidate the user's token
        return response()->json(['message' => 'User logged out successfully']);
    }
}
