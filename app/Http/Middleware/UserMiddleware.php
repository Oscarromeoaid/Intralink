<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        // Les admins et modérateurs sont redirigés vers leur propre dashboard
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        if (auth()->user()->role === 'moderator') {
            return redirect()->route('moderator.dashboard');
        }
        
        return $next($request);
    }
}