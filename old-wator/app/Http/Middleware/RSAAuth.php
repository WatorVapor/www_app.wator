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
        if (isset($status)) {
            if ( $status === 'success') {
                $name = $request->session()->get('account.rsa.login.name');
                if (isset($name)) {
                    view()->share('nav_login_show_name', $name);
                } else {
                    view()->share('nav_login_show_name', 'navbar.profile');
                }
                view()->share('nav_login_url', '/rsaauth/profile');
                view()->share('RSAAuth_Passed', true);
            } else {
                view()->share('nav_login_show_name', 'navbar.fix');
                view()->share('nav_login_url', '/rsaauth/fix');
                view()->share('RSAAuth_Passed', false);
            }
            view()->share('RSAAuth_AutoLogin', 'false');
        } else {
            view()->share('RSAAuth_Passed', false);
            view()->share('RSAAuth_AutoLogin', 'true');
        }
        $strRequest = uniqid();
        $accessID  = hash('sha512',$strRequest);
        view()->share('RSAAuth_Access', $accessID);
        return $next($request);
    }
}
