<?php

namespace Wator\Http\Controllers\PPio;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;

use WatorVapor\Http\Requests;

class AudioRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         return view('ppio.audiorecord');
   }
}
