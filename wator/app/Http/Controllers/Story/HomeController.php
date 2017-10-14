<?php

namespace Wator\Http\Controllers\story;
use Wator\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;


class HomeController extends Controller
{
    protected $storageRoot_;
    protected $locale_;
    protected $chapterOnce_;
    protected $animateNames_ = array();
    public function __construct() {
        $this->txtRoot_= '/repository/story';
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
        $output = shell_exec($cmd);
        $folders = explode("\n",$output);
        //var_dump($folders);
        $folders_ordered = [];
        foreach ($folders as $value) {
           $folders_ordered[] = (int)str_replace('/repository/story/zh/', '', $value);
        }
        sort($folders_ordered);
        //var_dump($folders_ordered);
        /*
        foreach ($folders_ordered as $value) {
           $folders_ordered[] = (int)str_replace('/repository/story/zh/', '', $value);
        }*/
        
        $chaptersInfo = array();
        $chaptersCounter = 0;
        foreach ($folders_ordered as $value) {
            $titlePath = $this->txtRoot_ . '/'. $this->locale_ . '/'. (string)$value . '/title';
            //var_dump($titlePath);
            if( file_exists($titlePath) ) {
                if($chaptersCounter >= $this->chapterOnce_) {
                    break;
                }
                $title = file_get_contents($titlePath);
                $chaptersInfo[$value] = $title;
                $chaptersCounter++;
            }
        }
        $data['chapters'] = $chaptersInfo;
        return view('story.home',$data);
    }
}
