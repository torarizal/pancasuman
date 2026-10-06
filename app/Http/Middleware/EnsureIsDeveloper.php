<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsDeveloper
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isDeveloper()) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses Developer Panel.');
        }

        return $next($request);
    }
}