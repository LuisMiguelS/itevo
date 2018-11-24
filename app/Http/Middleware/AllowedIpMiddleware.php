<?php

namespace App\Http\Middleware;

use Closure;

class AllowedIpMiddleware
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
        if ($this->isNormalUser()) {
            return $next($request);
        }

        abort_unless(
            $this->allowedIp($request),
            403,
            "No tiene autorización para conectarse fuera de ". config('app.name')
        );

        return $next($request);
    }

    protected function isNormalUser()
    {
        return auth()->user()->isSuperAdmin()
            || auth()->user()->isAdmin();
    }

    protected function allowedIp($request)
    {
        return in_array($request->getClientIp(), config('itevo.ip'));
    }
}
