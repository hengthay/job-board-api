<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index() {
        try {
            $users = User::where('is_active', 1)->get();
            
            if($users->isEmpty()) {
                return $this->handleErrorResponse(null, 'User is empty', 404);
            }

            // Send response back to frontend
            return $this->handleResponse($users, 'All users retrieve successful!', 200);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            $users = User::find($id);
            
            if(!$users) {
                return $this->handleErrorResponse(null, 'User with id:'. $id . ' is not found!', 404);
            }

            // Send response back to frontend
            return $this->handleResponse($users, 'User with id:'. $id . ' is successfully!', 200);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function getIndividualUser() {
        try {
            $userId = Auth::user()->id;

            $user = User::where('id', $userId)->first();

            if($user->isEmpty()) {
                return $this->handleErrorResponse(null, "User with id:". $userId . "not found!", 404);
            }

            return $this->handleResponse($user, "User with id:" . $userId . " successfully found!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function updateUser($id, Request $request) {
        try {
            // Find user
            $user = User::find($id);
            // Get current user
            $currentUser = Auth::user();

            if(!$user) {
                return $this->handleErrorResponse(null, 'User with id:'. $id . ' is not found!', 404);
            }

            // Check if user not matching and role is not admin
            if($currentUser->id !== $user->id && $currentUser->role !== 'admin') {
                return $this->handleErrorResponse(null, 'Unauthorized', 403);
            }

            // Update
            $validated = $request->validate([
                "name" => "required|string|max:256",
                "email" => "required|string|email",
                "role" => "nullable|string",
                "is_active" => "sometimes|integer",
            ]);

            $user->update($validated);

            return $this->handleResponse($user, "User is updated successfully!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function updateUserRole($id, Request $request) {
        try {
            // Find user
            $user = User::find($id);
            // Get current user
            $currentUser = Auth::user();

            if(!$user) {
                return $this->handleErrorResponse(null, 'User with id:'. $id . ' is not found!', 404);
            }
             
            // Check if user not matching and role is not admin
            if($currentUser->id !== $user->id && $currentUser->role !== 'admin') {
                return $this->handleErrorResponse(null, 'Unauthorized', 403);
            }

            // Update only role and is_active
            $validated = $request->validate([
                "role" => "sometimes|string",
                "is_active" => "sometimes|integer",
            ]);

            $user->update($validated);

            return $this->handleResponse($user, "User Role is updated successfully!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function removeUser($id) {
        try {
            // Find user
            $user = User::find($id);
            // Get current user
            $currentUser = Auth::user();

            // Log::debug('user', [
            //     'user' => $user
            // ]);

            if(!$user) {
                return $this->handleErrorResponse(null, 'User with id:'. $id . ' is not found to remove!', 404);
            }

            // Check if user not matching and role is not admin
            if($currentUser->id !== $user->id && $currentUser->role !== 'admin') {
                return $this->handleErrorResponse(null, 'Unauthorized', 403);
            }

            // Update only is_active to 0
            $user->update([
                'is_active' => 0
            ]);

            return $this->handleResponse(null, "User is removed successfully!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
