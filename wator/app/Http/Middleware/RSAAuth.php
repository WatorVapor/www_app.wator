<?php

namespace Wator\Http\Middleware;

use Closure;

class RSAAuth
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
        $status = $request->session()->get('account.rsa.login.status');
        if (isset($status) {
            if ( $status === 'success') {
                $name = $request->session()->get('account.rsa.login.name');
                if (isset($name) {
                    view()->share('nav_login_show_name', $name);
                } else {
                    view()->share('nav_login_show_name', 'navbar.profile');
                }
                view()->share('nav_login_url', '/account/profile');
            } else {
                view()->share('nav_login_show_name', 'navbar.fix');
                view()->share('nav_login_url', '/account/fix');
            }
        }
        return $next($request);
    }
}
