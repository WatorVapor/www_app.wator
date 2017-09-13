<?php

namespace WatorVapor\Http\Controllers;

use Illuminate\Http\Request;

class AudioShareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('audio_share');
    }
}
