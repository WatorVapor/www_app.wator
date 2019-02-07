<?php

namespace Wator\Http\Middleware;

use Closure;

class SecAuth
{
    const LOGIN_URL_ = 'http://www.wator.xyz/secauth/login/auto';
    
    const LOGIN_URL_SSL_ = 'https://www.wator.xyz/secauth/login/auto';
    
    const LOGOUT_URL_ = 'http://www.wator.xyz/secauth/logout';
    const LOGSIGNUP_URL_ = 'http://www.wator.xyz/secauth/signup';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //var_dump($request->url());
        //var_dump($request->fullUrl());
        if($request->fullUrl() == self::LOGOUT_URL_) {
          view()->share('SecAuth_Passed', false);
          return $next($request);
        }        
        if($request->fullUrl() == self::LOGSIGNUP_URL_) {
          view()->share('SecAuth_Passed', false);
          return $next($request);
        }        
        if ($request->isMethod('post')) {
          return $next($request);
        }
        
        
       $status = $request->session()->get('account.sec.login.status');
        //var_dump($status);
        if (isset($status)) {
            if ( $status === 'success') {
                $name = $request->session()->get('account.sec.login.name');
                if (isset($name)) {
                    view()->share('nav_login_show_name', $name);
                } else {
                    view()->share('nav_login_show_name', 'navbar.profile');
                }
                view()->share('nav_login_url', '/secauth/profile');
                view()->share('SecAuth_Passed', true);
            } else {
                view()->share('nav_login_show_name', 'navbar.fix');
                view()->share('nav_login_url', '/secauth/fix');
                view()->share('SecAuth_Passed', false);
            }
            //view()->share('SecAuth_AutoLogin', 'false');
        } else {
            view()->share('SecAuth_Passed', false);
            //view()->share('SecAuth_AutoLogin', 'true');
            if($request->fullUrl() != self::LOGIN_URL_) {
                $redirecting = $request->session()->get('account.sec.login.redirecting');
                //var_dump($redirecting);
                if (!isset($redirecting)) {
                  $request->session()->put('account.sec.login.redirecting','yes');
                  return redirect(self::LOGIN_URL_SSL_);
                }
            }
        }
        $strRequest = uniqid();
        $accessID  = hash('sha256',$strRequest);
        view()->share('SecAuth_Access', $accessID);
        return $next($request);
    }
}
