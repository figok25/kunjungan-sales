<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSales
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isSales()) {
            abort(403, 'Hanya Sales yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
