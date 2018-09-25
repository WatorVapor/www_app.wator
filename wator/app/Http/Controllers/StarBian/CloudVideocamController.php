<?php
namespace Wator\Http\Controllers\StarBian;
use Wator\Http\Controllers\Controller;
use Illuminate\Http\Request;
class CloudVideocamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($remote = null)
    {
        return view('starbian.videocam');
    }
    public function index_cast($remote = null)
    {
        if(isset($remote)) {
            return view('starbian.videocam_cast',['remote'=>$remote]);
        } else {
            return view('starbian.videocam_cast',['remote'=>'']);
        }
    }
    public function index_recv($remote = null)
    {
        if(isset($remote)) {
            return view('starbian.videocam_recv',['remote'=>$remote]);
        } else {
            return view('starbian.videocam_recv',['remote'=>'']);
        }
    }
    
    public function index_m($remote = null)
    {
        return view('starbian.videocam_m');
    }
    public function index_cast_m($remote = null)
    {
        if(isset($remote)) {
            return view('starbian.videocam_cast_m',['remote'=>$remote]);
        } else {
             return view('starbian.videocam_cast_m',['remote'=>'']);
       }
    }
    public function index_recv_m($remote = null)
    {
        if(isset($remote)) {
            return view('starbian.videocam_recv_m',['remote'=>$remote]);
        } else {
             return view('starbian.videocam_recv_m',['remote'=>'']);
       }
    }
}
