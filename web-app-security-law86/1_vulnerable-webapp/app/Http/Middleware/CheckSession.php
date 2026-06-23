<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Simple session-based auth middleware
 * Redirects to login if no session found
 */
class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user_id')) {
            return redirect('/login')->with('error', 'Please login first.');
        }
        return $next($request);
    }
}
