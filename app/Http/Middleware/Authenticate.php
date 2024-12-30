<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {

        // Check if the request is authenticated
        if (Auth::guard($guard)->guest()) {
            // Respond with a JSON error message for API requests
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Continue with the request if authenticated
        return $next($request);
    }

}
