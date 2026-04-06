<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $role) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Flash the message after the session has been regenerated
            $request->session()->flash('error', 'Akses ditolak! Hanya Super Admin yang diizinkan.');

            return redirect()->route('login');
        }

        return $next($request);
    }
}
