<?php
namespace Wator\Http\Controllers\AIBot;

use Wator\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;

class WeiboController extends Controller
{
     protected $tokenRoot_;
     public function __construct() {
          $this->tokenRoot_ = '/opt/rsaauth/weibo';
          File::makeDirectory($this->tokenRoot_, 0775, true, true);
     }
    public function auth()
    {
        //
        return \Socialite::with('weibo')->redirect();
    }
    public function index()
    {
        //
        try {
            $oauthUser = \Socialite::with('weibo')->user();
            $token = $oauthUser->token;
            var_dump($token);
            if($token) {
                $tokenPath = $this->tokenRoot_ . '/access_token';
                 var_dump($token);
                file_put_contents($tokenPath, $token);
            }
        } catch( \Exception $e ) {
            var_dump($e->getMessage());
        }
        return view('aibot.weibo');
    }
    public function cancel()
    {
        //
        try {
        } catch( \Exception $e ) {
            var_dump($e->getMessage());
        }
        return view('aibot.weibo_cancel');
    }
}
