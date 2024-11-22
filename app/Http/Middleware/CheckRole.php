<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Verifica si el usuario tiene el rol adecuado
        if (!Auth::check() || Auth::user()->role !== $role) {
            return redirect('home')->with('error', 'No tienes acceso a esta sección.');
        }

        return $next($request);
    }
}
