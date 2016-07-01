<?php

namespace App\Http\Middleware;

use Closure;

class NoSniff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
          ->header("X-Content-Type-Options", "nosniff")
          ->header("X-XSS-Protection", "1; mode=block")
          ->header("X-Frame-Options", "SAMEORIGIN");
    }
}