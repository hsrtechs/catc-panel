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
        $actions = $request->route()->getAction();
        if (!isset($actions['permissions'])) {
            return response('No Permissions defined', 301);
        } elseif (!$request->user()->hasAnyPermission($actions['permissions'])) {
            return response('Un-Authorized', 401);
        }
        return $next($request);
    }

}
