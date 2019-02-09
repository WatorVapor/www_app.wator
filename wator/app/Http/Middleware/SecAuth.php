<?php

namespace Wator\Http\Middleware;

use Closure;

class SecAuth
{
    const LOGIN_URL_SSL_ = 'https://www.wator.xyz/secauth/login/auto';
    const LOGIN_PATH_ = 'secauth/login';
    const LOGIN_PATH_AUTO_ = 'secauth/login/auto';
    const EXECEPTION_ = [
        'secauth/login',
        'secauth/login/auto',
        'secauth/login/failure',
        'secauth/logout',
        'secauth/signup',
        'secauth/import'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        view()->share('SecAuth_Passed', false);
        //var_dump($request->url());
        //var_dump($request->fullUrl());
        $path = $request->path();
        //var_dump($path);
        $isExecept = in_array($path, self::EXECEPTION_);
        //var_dump($isExecept);
        if ($isExecept) {
          return $next($request);
        }        
       $status = $request->session()->get('account.sec.login.status');
        //var_dump($status);
        if (isset($status)) {
            $request->session()->put('account.sec.login.previou.path',$path);
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
            }
            //view()->share('SecAuth_AutoLogin', 'false');
        } else {
            //view()->share('SecAuth_AutoLogin', 'true');
            if($path != self::LOGIN_PATH_ && $path != self::LOGIN_PATH_AUTO_) {
                $redirecting = $request->session()->get('account.sec.login.redirecting');
                //var_dump($redirecting);
                if (!isset($redirecting)) {
                  $request->session()->put('account.sec.login.redirecting','yes');
                  $request->session()->put('account.sec.login.previou.path',$path);
                  return redirect(self::LOGIN_URL_SSL_);
                }
            } else  {
              if($request->isMethod('post')) {
                  return $next($request);
              }
            }
        }
        return $next($request);
    }
}
