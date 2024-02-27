<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * @see https://stackoverflow.com/a/52052343
         */
        $allowedOrigins = ['localhost:5173'];
        $origin = $request->server('HTTP_ORIGIN');

        if (in_array($origin, $allowedOrigins)) {
            return $next($request)
                ->header('Access-Control-Allow-Origin', '*');
        }
        return $next($request);
    }
}
