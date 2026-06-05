<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAccountIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->account_status != 'active') {
            // Allow logout request so they can sign out
            if ($request->routeIs('logout')) {
                return $next($request);
            }

            // Redirect any GET requests back to the dashboard if they attempt to navigate to another page
            if ($request->isMethod('get') && !$request->routeIs('dashboard')) {
                return redirect()->route('dashboard');
            }

            // Block any non-GET requests (like transfers or updates) and redirect to dashboard
            if (!$request->isMethod('get')) {
                return redirect()->route('dashboard')->with('message', 'Your account is restricted. Action denied.');
            }
        }

        return $next($request);
    }
}
