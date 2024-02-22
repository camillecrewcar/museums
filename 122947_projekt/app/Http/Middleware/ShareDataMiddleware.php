<?php

namespace App\Http\Middleware;

use App\Models\Cities;
use App\Models\Tags;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $cities = Cities::all();
        View::share('cities', $cities);
        $tag = Tags::all();
        View::share('tag', $tag);

        return $next($request);
    }
}
