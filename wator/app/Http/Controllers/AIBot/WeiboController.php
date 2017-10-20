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
            var_dump($oauthUser->token);
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
