<?php
namespace Wator\Http\Controllers\PPio;
use Wator\Http\Controllers\Controller;
use Illuminate\Http\Request;
class CloudGoFuroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('ppio.gofuro');
    }
}
