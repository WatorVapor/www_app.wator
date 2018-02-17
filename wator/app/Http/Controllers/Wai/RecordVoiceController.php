<?php
namespace Wator\Http\Controllers\Wai;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;


use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Wator\Notifications\TwitterParticipleNotification;
use Wator\Notifications\FacebookParticipleNotification;
use Wator\Notifications\WeiboParticipleNotification;

use Illuminate\Support\Facades\Redis;


class RecordVoiceController extends Controller
{
    use Notifiable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        //var_dump($data);
        return view('wai.recorder_voice',$data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
        } catch (\Exception $e) {
        }
        return redirect()->back();
    }
}
