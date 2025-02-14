<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            abort(403, 'Not Logged In');
        }

        // Debugging: Check assigned role
        if (!auth()->user()->role) {
            abort(403, 'User has no role assigned');
        }

        if (auth()->user()->role->name !== $role) {
            abort(403, 'You do not have the required role: ' . $role . ' (Your Role: ' . auth()->user()->role->name . ')');
        }

        return $next($request);
    }
}
