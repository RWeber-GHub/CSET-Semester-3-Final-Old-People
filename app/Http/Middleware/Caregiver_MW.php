<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class Caregiver_MW
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('user') || Session::get('user.RoleID') != 4) {
            return redirect('/login');
        }

        return $next($request);
    }
}
