<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocalizeAPI
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $locale = $request->hasHeader('Accept-Language') ? $request->header('Accept-Language') : config('app.fallback_locale');

        app()->setLocale($locale);

        return $next($request);

    }
}
