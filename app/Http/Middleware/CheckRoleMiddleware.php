<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        // Check if the user is authenticated
        if (!auth()->check()) {
            abort(403, 'Unauthorized.');
        }
        // Allow if user has any of the required roles
        if (!auth()->user()->hasAnyRole($roles)) {
            abort(403, 'Access denied.');
        }
        return $next($request);
    }
}
