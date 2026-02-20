<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->Role;

        $roleMatch = false;
        foreach ($roles as $role) {
            if (strtolower($userRole) === strtolower($role)) {
                $roleMatch = true;
                break;
            }
        }

        if (!$roleMatch) {
            abort(403, 'Unauthorized. Required roles: ' . implode(', ', $roles));
        }

        return $next($request);
    }
}
