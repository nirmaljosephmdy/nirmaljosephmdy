<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserRole;
use App\Support\ApiResponse;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return $request->expectsJson()
                ? ApiResponse::error('Unauthenticated.', 401)
                : redirect()->route('login');
        }

        $userRole = auth()->user()->role;
        $requiredRole = constant(UserRole::class . '::' . \Illuminate\Support\Str::studly($role)) ?? null;

        if ($requiredRole === null) {
            // Alternatively string mapping:
            if ($role === 'admin') $requiredRole = UserRole::Admin;
            if ($role === 'manufacturer') $requiredRole = UserRole::Manufacturer;
        }

        if (auth()->user()->is_blocked) {
            auth()->logout();
            return $request->expectsJson()
                ? ApiResponse::error('Your account has been suspended.', 403)
                : redirect()->route('login')->with('error', 'Your account has been suspended.');
        }

        if ($userRole !== $requiredRole) {
            return $request->expectsJson()
                ? ApiResponse::error('Unauthorized access.', 403)
                : redirect('/')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
