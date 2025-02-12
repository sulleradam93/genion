<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthRedirectMiddleware
{
    
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() && !$request->is('login')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
