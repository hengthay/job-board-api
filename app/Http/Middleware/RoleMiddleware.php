<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {   
        // Get current user
        $user = $request->user();
        // If user didn't exist
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        // trim the whitespace
        $roles = array_map('trim', $roles);
        // Check if the role is not matching
        if (!in_array($user->role, $roles, true)) {
            return response()->json(['message' => 'Forbidden to access.'], 403);
        }
        // Return next requset
        return $next($request);
    }
}
