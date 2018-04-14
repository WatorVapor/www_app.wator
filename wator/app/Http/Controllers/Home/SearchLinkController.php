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
                if(startsWith($uri,'rsaauth')) {
                    $urls[] = $uri;
                }
            }
        }
        $autoGenfiles = shell_exec('find /autogen/');
        var_dump($autoGenfiles);
        
        
        //var_dump($urls);
        return view('home.serch_link',['watorapp'=>'home','urls'=>$urls]);
    }
    
    
    function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }
    function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }
    
}
