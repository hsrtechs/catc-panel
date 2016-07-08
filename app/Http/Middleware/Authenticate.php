<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest())
        {
            if ($request->ajax() || $request->wantsJson())
            {
                return response('Unauthorized.', 401);
            } else
            {
                return redirect()->guest('login');
            }
        } elseif(Auth::user()->isActivated())
        {
            Auth::guard($guard)->logout();
            return response('Unactivated Account.', 401);
        } elseif(Auth::user()->isSuspended())
        {
            Auth::guard($guard)->logout();
            return response('Hello your account is been suspended please contact the support for further assistance.', 401);
        } elseif(Auth::user()->isActivated())
        {
            Auth::guard($guard)->logout();
            return response('Hello your account is been terminated please contact the support for further assistance.', 401);
        }

        return $next($request);
    }
}
