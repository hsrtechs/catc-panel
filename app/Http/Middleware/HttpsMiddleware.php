<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpsMiddleware
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

        if(!$request->isSecure() && env('APP_SSL_ENABLE') === true)
        {
            redirect()->secure($request->getRequestUri());
        }
        return $next($request);
    }
}
