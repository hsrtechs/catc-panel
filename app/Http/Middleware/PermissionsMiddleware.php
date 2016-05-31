<?php

namespace App\Http\Middleware;

use Closure;

class PermissionsMiddleware
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
            redirect()->action('Auth\AuthController@login');
        }
        $actions = $request->route()->getAction();
        if (!isset($actions['permissions'])) {
            return $next($request);
        } elseif (!$request->user()->hasAnyPermission($actions['roles'])) {
            return response('Un-Authorized', 401);
        }
        return $next($request);
    }

}
