<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // Check if the user is authenticated and if the role matches
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        // Unauthorized response if the role doesn't match
        return response()->json(['message' => 'Unauthorized.'], 403);
    }
}
