<?php

namespace Wator\Http\Controllers\Ethereum;
use Wator\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;


class EthereumController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index($position = null)
    {
        return view('ethereum.home');
    }
}
