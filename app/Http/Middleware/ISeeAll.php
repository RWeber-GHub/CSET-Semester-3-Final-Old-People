<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class ISeeAll
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('user') || Session::get('user.RoleID') != 1) {
            return redirect('/login');
        }

        return $next($request);
    }
}

