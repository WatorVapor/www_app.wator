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
        //
        if(isset($remote)) {
            return view('starbian.videocam_r');
        } else {
            return view('starbian.videocam');
        }
    }
}
