<?php

namespace App\Http\Middleware;

use Closure;

class SafariFixAuth
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

        $authorizationToken = $request->headers->get('MMAuthorization');

        if ($authorizationToken !== null) {
            $request->headers->set('Authorization', $authorizationToken);
        }

        return $next($request);
    }
}
