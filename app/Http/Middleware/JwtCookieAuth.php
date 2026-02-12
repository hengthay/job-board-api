<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtCookieAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // parseToken read JWT token in request header
            // authenticate decode token an fetch user and assign founded user to $user variable
            /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 401);
            }
            // Set the current logged user as authenticated user with authenticate system guard
            auth()->guard('api')->setUser($user);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token invalid'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
