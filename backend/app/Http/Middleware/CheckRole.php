<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // cek apakah user suda login dan apakah rolenya ada dalam parameter yg diizinkan
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            abort(430, 'Unathorized action.');
        }

        return $next($request);
    }
}
