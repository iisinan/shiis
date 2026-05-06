<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPaid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->is_paid) {
            // Allow access to dashboard and profile only
            if (!$request->is('dashboard') && !$request->is('profile*') && !$request->is('logout')) {
                return redirect()->route('dashboard')->with('error', 'Your account is pending verification. Please wait for an administrator to activate your account.');
            }
        }

        return $next($request);
    }
}
