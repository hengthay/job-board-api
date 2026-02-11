<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request) {
        try {
            // Get user input data and validate
            $credentials = $request->validate([
                'name' => "required|string|max:255",
                'password' => "required|string",
            ]);
            // Check if user exists
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 'error',
                    'message' => 'Invalid credentials'
                ], 401);
            }
            // Return success message and provided token
            return response()->json([
                'status_code' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'user' => JWTAuth::user(),
                    'bearer token type' => $token,
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'status_code' => 'error',
                'message' => 'Login failed',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }
    public function register(Request $request) {
        try {
            // Get uset input data and validate
            $request->validate([
                'name' => "required|string|max:255",
                'email' => "required|string",
                'password' => "required|string",
            ]);
            // Create new user and hash password
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            // Return success message
            return response()->json([
                'status_code' => 'success',
                'message' => 'Register successful',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'status_code' => 'error',
                'message' => 'Register failed',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }
    public function logout(Request $request) {
        try {
            // Get current token from user and invalid it for logout
            JWTAuth::invalidate(JWTAuth::getToken());
            // Return success message
            return response()->json([
                'status_code' => 'success',
                'message' => 'Logout successful'
            ]);  
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'status_code' => 'error',
                'message' => 'Logout failed',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }
}
