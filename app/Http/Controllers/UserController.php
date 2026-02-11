<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        try {
            $users = User::where('is_active', 1)->get();
            
            if(!$users) {
                return $this->handleErrorResponse(null, 'User is empty', 404);
            }

            // Send response back to frontend
            return $this->handleResponse($users, 'All users retrieve successful!', 200);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
