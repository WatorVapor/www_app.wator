<?php
namespace Wator\Http\Controllers\AIBot;

use Wator\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use Thujohn\Twitter\Twitter;
use Thujohn\Twitter\Facades\Twitter;

class TwitterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Twitter::postTweet(array('status' => '面倒くさそうにしてるキャラを格好良いと思ってたのが間違いだったんだと思う', 'format' => 'json'));
    }
}
