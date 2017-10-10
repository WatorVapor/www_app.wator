<?php

namespace WatorVapor\Http\Controllers;

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
         return view('audiorecord');
   }
}
