<?php
namespace Wator\Http\Controllers\Home;
use Illuminate\Http\Request;
use Wator\Http\Controllers\Controller;
class SearchLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('home.serch_link',['watorapp'=>'home']);
    }
}
