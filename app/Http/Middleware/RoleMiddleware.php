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
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        if (!in_array($user->rol, $roles)) {
            abort(403, 'No autorizado');
        }

        return $next($request);
    }
}

