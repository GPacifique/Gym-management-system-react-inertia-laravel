<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Usage:
     * checkrole:manager
     * checkrole:manager,receptionist
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $userRole = strtolower($request->user()->role ?? '');
        $allowedRoles = array_map('strtolower', $roles);

        // Super admin bypass (optional but recommended)
        if ($userRole === 'super_admin') {
            return $next($request);
        }

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}