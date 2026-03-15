<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function getIndividualUser() {
        try {
            $userId = Auth::user()->id;

            $user = User::where('id', $userId)->get();

            if($user->isEmpty()) {
                return $this->handleErrorResponse(null, "User with id:". $userId . "not found!", 404);
            }

            return $this->handleResponse($user, "User with id:" . $userId . " successfully found!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
