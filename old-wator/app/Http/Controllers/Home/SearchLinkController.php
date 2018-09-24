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
            if (in_array("GET", $value->methods())) {
                $uri =  $value->uri();
                $urls[] = $uri;
            }
        }
        $autoGenfiles = shell_exec('find /autogen/wator/wai/static/*.html ');
        //var_dump($autoGenfiles);
        $autoGenArray = explode("\n", $autoGenfiles);
        //var_dump($autoGenArray);
        foreach ($autoGenArray as $file)
        {
            $uri = str_replace('/autogen/wator','autogen',$file);
            $urls[] = $uri;
        }
        
        
        //var_dump($urls);
        return view('home.serch_link',['watorapp'=>'home','urls'=>$urls]);
    }    
}
