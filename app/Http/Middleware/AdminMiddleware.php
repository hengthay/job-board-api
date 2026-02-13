<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        Log::debug('user info', ['user' => $user]);

        if(!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        if(($user->role ?? null) !== 'admin') {
            return response()->json([
                'message' => 'Forbidden - Admin only'
            ], 401);
        }
        return $next($request);
    }
}
