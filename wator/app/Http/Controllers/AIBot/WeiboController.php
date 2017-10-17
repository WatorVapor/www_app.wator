<?php
namespace Wator\Http\Controllers\AIBot;

use Wator\Http\Controllers\Controller;
use Illuminate\Http\Request;


class WeiboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('aibot.weibo');
    }
    public function cancel()
    {
        //
        return view('aibot.weibo_cancel');
    }
}
