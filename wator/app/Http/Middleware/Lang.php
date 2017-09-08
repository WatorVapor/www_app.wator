<?php

namespace Wator\Http\Middleware;

use Closure;

class Lang
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
        $lang = $request->session()->get('user.operation.lang');
        if (isset($lang) {
            app()->setLocale($lang);
        }
        return $next($request);
    }
}
