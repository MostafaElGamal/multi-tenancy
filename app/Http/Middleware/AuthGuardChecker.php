<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;

use Illuminate\Support\Facades\Auth;

use Closure;

class AuthGuardChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check($guard)) {
            return $next($request);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
