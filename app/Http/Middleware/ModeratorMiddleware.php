<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModeratorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if (!auth()->check() || !in_array($user->role, ['admin', 'moderator'])) {
            abort(403, 'Accès non autorisé. Zone modérateur.');
        }
        
        return $next($request);
    }
}