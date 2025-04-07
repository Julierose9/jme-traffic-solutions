<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user's role matches one of the allowed roles
        if (!in_array($user->role, $roles)) {
            return redirect()->route('welcome')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}