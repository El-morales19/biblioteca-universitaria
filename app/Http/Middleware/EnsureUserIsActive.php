<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->active) {
            
            // Permitimos explícitamente cerrar sesión o ver la pantalla de bloqueado
            // para evitar un bucle infinito de redirecciones.
            if ($request->routeIs('logout') || $request->routeIs('account.disabled')) {
                return $next($request);
            }

            return redirect()->route('account.disabled');
        }

        return $next($request);
    }
}
