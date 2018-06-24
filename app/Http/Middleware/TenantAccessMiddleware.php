<?php

namespace App\Http\Middleware;

use Closure;
use App\Institute;
use Symfony\Component\HttpFoundation\Response;

class TenantAccessMiddleware
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
        abort_unless($this->thisUserIsAuthorized($request), Response::HTTP_FORBIDDEN);

        return $next($request);
    }

    /**
     * @param $request
     * @return bool
     */
    private function thisUserIsAuthorized($request): bool
    {
        return auth()->user()->isAssignedTo($this->getInstaceInstitute($request->institute)) || auth()->user()->isAdmin();
    }

    /**
     * @param $institute
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private function getInstaceInstitute($institute)
    {
        if ($institute instanceof Institute) {
            return $institute;
        }
        return Institute::findOrFail($institute);
    }
}
