<?php
namespace Wator\Http\Controllers\Home;
use Illuminate\Http\Request;
use Wator\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

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
        $routeList = Route::getRoutes();
        $urls = [];
        foreach ($routeList as $value)
        {
            //var_dump($value->uri());
            var_dump($value->methods());
            $urls[] = $value->uri();
        }
        //var_dump($urls);
        return view('home.serch_link',['watorapp'=>'home','urls'=>$urls]);
    }
}
