<?php

namespace App\Http\Middleware;

use Closure;

class ServerOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() === NULL) {
            return redirect()->action('Auth\AuthController@login');
        } elseif ($request->user()->isAdmin() || $request->user()->isMod()) {
            return $next($request);
        } elseif (!$request->user()->ownsServer($request->id)) {
            return response('Un-Authorized', 401);
        }
        return $next($request);
    }
}
