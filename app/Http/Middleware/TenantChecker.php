<?php

namespace App\Http\Middleware;

use Closure;

class TenantChecker
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
        $hostname  = app(\Hyn\Tenancy\Environment::class)->hostname();
        $fqdn = optional($hostname)->fqdn; // Fully Qualified Domain
        if ($fqdn) {
            config(['database.default' => 'tenant']);
            return $next($request);
        }
        return response()->json(['error' => 'No Tenant Implemented'], 501);
    }
}
