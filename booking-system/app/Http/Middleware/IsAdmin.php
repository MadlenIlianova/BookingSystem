<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Провери дали потребителят е логнат И е администратор
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Нямате достъп до тази страница. Само администратори имат достъп.');
        }

        return $next($request);
    }
}