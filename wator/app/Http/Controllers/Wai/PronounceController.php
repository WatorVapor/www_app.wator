<?php

namespace Wator\Http\Controllers\Wai;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PronounceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ja50on($yinjie = null)
    {
        //
        $data = [];
        if(isset($yinjie)) {
          $data['yinjie'] = $yinjie;
        } else {
          $data['yinjie'] = 'あ';
        }
        return view('wai.pronouce.ja50on',$data);
    }
}