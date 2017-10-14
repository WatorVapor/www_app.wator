<?php

namespace StoryWator\Http\Controllers;

use Illuminate\Http\Request;

use StoryWator\Http\Requests;

use App;

use Log;

class HomeController extends Controller
{
    protected $storageRoot_;
    protected $locale_;
    protected $chapterOnce_;
    protected $animateNames_ = array();
    public function __construct() {
        $this->txtRoot_= '/opt/watorvapor/repository.wator/story';
        $this->locale_='zh';
        $this->chapterOnce_=45;
        $this->animateNames_[]= 'type';
        $this->animateNames_[]= 'type2';
        $this->animateNames_[]= 'type3';
        $this->animateNames_[]= 'type4';
        $this->animateNames_[]= 'type5';
        $this->animateNames_[]= 'type6';
        $this->animateNames_[]= 'type7';
        $this->animateNames_[]= 'type8';
        $this->animateNames_[]= 'read';
        $this->animateNames_[]= 'read2';
        $this->animateNames_[]= 'read3';
        $this->animateNames_[]= 'write';
        $this->animateNames_[]= 'think';
        $this->animateNames_[]= 'think2';
        $this->animateNames_[]= 'think3';
        $this->animateNames_[]= 'think4';
        $this->animateNames_[]= 'think5';
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index($position = null)
    {
        //
        $index = rand(0,sizeof($this->animateNames_) -1);
        $animate = $this->animateNames_[$index];
        $data = ['animate'=>$animate];
        $cmd = 'find ' . $this->txtRoot_ . ' -mindepth 2 -maxdepth 2 -type d | sort -t / -k 7 -n';
        //Log::info($cmd);
        $output = shell_exec($cmd);
        //Log::info($output);
        $folders = explode("\n",$output);
        //Log::info($folders);
        $chaptersInfo = array();
        $chaptersCounter = 0;
        foreach ($folders as $value) {
            //Log::info('$value=<' . $value . '>');
            $titlePath = $value . '/title';
            //Log::info('$value=<' . $titlePath . '>');
            if( file_exists($titlePath) ) {
                //Log::info($value);
                $chapter = str_replace($this->txtRoot_ ,'',$value);
                $pieces = explode("/",$chapter);
                //Log::info($pieces);
                if($pieces[1] == $this->locale_) {
                    if($chaptersCounter >= $this->chapterOnce_) {
                        break;
                    }
                    $title = file_get_contents($titlePath);
                    //Log::info($title);
                    //Log::info($pieces[2]);
                    $chaptersInfo[$pieces[2]] = $title;
                    $chaptersCounter++;
                }
            }
        }
        //Log::info($chaptersInfo);
        $data['chapters'] = $chaptersInfo;
        return view('home',$data);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }
}
