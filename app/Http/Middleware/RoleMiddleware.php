<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated and has one of the allowed roles
        if (!auth()->check() || !in_array(auth()->user()->role->name, $roles)) {
            return abort(403, "You do not have the required role: " . implode(', ', $roles) . " (Your Role: " . auth()->user()->role->name . ")");
        }

        return $next($request);
    }
}
