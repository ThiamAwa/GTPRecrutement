<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Vérifiez si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect('login'); // Redirigez si l'utilisateur n'est pas authentifié
        }

        // Obtenez l'utilisateur authentifié
        $user = Auth::user();

        // Vérifiez si l'utilisateur a un rôle
        if (!$user->role) {
            return redirect('unauthorized'); // Redirigez si l'utilisateur n'a pas de rôle
        }

        // Vérifiez le rôle de l'utilisateur
        if ($user->role->name !== $role) {
            return redirect('unauthorized'); // Redirigez si l'utilisateur n'a pas le rôle requis
        }

        // Continuez la requête
        return $next($request);
    }
}
