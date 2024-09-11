<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Verificar si el rol del usuario está en la lista de roles permitidos
        if (!$user->hasAnyRole($roles)) {
            return response()->json(['message' => 'Forbidden', 'user' => $user], 403);
        }

        return $next($request);
    }
}
