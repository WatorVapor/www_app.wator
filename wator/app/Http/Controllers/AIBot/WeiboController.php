<?php
namespace Wator\Http\Controllers\AIBot;

use Wator\Http\Controllers\Controller;
use Illuminate\Http\Request;


class WeiboController extends Controller
{
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
            var_dump($oauthUser->accessTokenResponseBody);
            var_dump($oauthUser->accessTokenResponseBody['access_token']);
            var_dump($oauthUser->getId());
            var_dump($oauthUser->getNickname());
            var_dump($oauthUser->getName());
            var_dump($oauthUser->getEmail());
            var_dump($oauthUser->getAvatar());        
        } catch( \Exception $e ) {
            var_dump($e->getMessage());
        }
        return view('aibot.weibo');
    }
    public function cancel()
    {
        //
        try {
            $oauthUser = \Socialite::with('weibo')->user();
            var_dump($oauthUser->getId());
            var_dump($oauthUser->getNickname());
            var_dump($oauthUser->getName());
            var_dump($oauthUser->getEmail());
            var_dump($oauthUser->getAvatar());        
        } catch( \Exception $e ) {
            var_dump($e->getMessage());
        }
        return view('aibot.weibo_cancel');
    }
}
