<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PekebunMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'pekebun') {
            return $next($request);
        }

        return redirect('/admin/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman pekebun.');
    }
}
