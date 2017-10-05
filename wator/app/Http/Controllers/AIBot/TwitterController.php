<?php
namespace Wator\Http\Controllers;
use Illuminate\Http\Request;

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
        //return Twitter::getHomeTimeline(['count' => 2, 'format' => 'json']);
    }
}
