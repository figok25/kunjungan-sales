<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOwnerOrAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || (! $user->isOwner() && ! $user->isAdmin())) {
            abort(403, 'Hanya Owner atau Admin yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
