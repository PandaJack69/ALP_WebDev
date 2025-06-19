<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the current user's role
            $currentRole = Auth::user()->current_role;

            // Redirect based on role
            if ($currentRole === 'merchant') {
                return redirect()->route('merchant-dashboard');
            } elseif ($currentRole === 'user') {
                return redirect()->route('user-dashboard');
            }
        }

        return $next($request);
    }
}