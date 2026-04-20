<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (strtolower(auth()->user()->role) != strtolower($role)) {
            abort(403);
        }

        return $next($request);
    }
}