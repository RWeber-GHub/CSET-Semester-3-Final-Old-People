<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ISeeAll
{
    public function handle(Request $request, Closure $next)
    {
        // If no session, force login
        if (!session()->has('roleid')) {
            return redirect('/login')->withErrors(['Please log in first.']);
        }

        // Compare as string to avoid type mismatch issues
        if ((string) session('roleid') !== "1") {
            return redirect('/')->withErrors(['Unauthorized access.']);
        }

        return $next($request);
    }
}
