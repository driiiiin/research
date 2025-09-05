<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RequirePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // If password change is required and user is not already on password change page
            if ($user->isPasswordChangeRequired() &&
                !$request->routeIs('password.change') &&
                !$request->routeIs('password.change.store') &&
                !$request->routeIs('logout')) {

                // Redirect to password change page
                return redirect()->route('password.change')
                    ->with('warning', 'You must change your password before continuing.');
            }
        }

        return $next($request);
    }
}
