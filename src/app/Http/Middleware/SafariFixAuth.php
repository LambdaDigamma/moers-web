<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SafariFixAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $authorizationToken = $request->headers->get('MMAuthorization');

        if ($authorizationToken !== null) {
            $request->headers->set('Authorization', $authorizationToken);
        }

        return $next($request);
    }
}
