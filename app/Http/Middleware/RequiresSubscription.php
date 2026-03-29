<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Support\ApiResponse;
use App\Models\Subscription;

class RequiresSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return $request->expectsJson()
                ? ApiResponse::error('Unauthenticated.', 401)
                : redirect()->route('login');
        }

        // Only block if role is Manufacturer and subscription is missing/expired
        if ($user->role === \App\Enums\UserRole::Manufacturer) {
            if (!$user->hasActiveSubscription()) {
                return $request->expectsJson()
                    ? ApiResponse::error('Active subscription required.', 403)
                    : redirect()->route('app.subscription.required')->with('error', 'Active subscription required.');
            }
        }

        return $next($request);
    }
}
