<?php

namespace Wator\Http\Controllers\StarBian;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BLECastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('starbian.ble_cast');
    }
}
