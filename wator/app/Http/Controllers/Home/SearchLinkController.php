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
            $uri = 'https://www.wator.xyz/' . str_replace('/wator/','/',$file);
            $urls[] = $uri;
        }
        
        
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
