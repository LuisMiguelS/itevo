<?php

namespace App\Http\Middleware;

use App\institute;
use Silber\Bouncer\Bouncer;

use Closure;

class ScopeBouncer
{
    /**
     * The Bouncer instance.
     *
     * @var \Silber\Bouncer\Bouncer
     */
    protected $bouncer;

    /**
     * Constructor.
     *
     * @param \Silber\Bouncer\Bouncer  $bouncer
     */
    public function __construct(Bouncer $bouncer)
    {
        $this->bouncer = $bouncer;
    }

    /**
     * Set the proper Bouncer scope for the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Here you may use whatever mechanism you use in your app
        // to determine the current tenant. To demonstrate, the
        // $tenantId is set here from the user's account_id.
        if (isset($request->institute)) {
            $tenantId = $this->getInstaceInstitute($request->institute)->id;
            $this->bouncer->scope()->to($tenantId);
        }

        return $next($request);
    }

    /**
     * @param $institute
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    protected function getInstaceInstitute($institute)
    {
        if ($institute instanceof Institute) {
            return $institute;
        }

        return Institute::findOrFail($institute);
    }
}
