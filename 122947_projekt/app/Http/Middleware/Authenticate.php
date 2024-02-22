<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;


class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role == 1) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
