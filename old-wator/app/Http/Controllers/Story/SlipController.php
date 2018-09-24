<?php

namespace Wator\Http\Controllers\Story;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;


class SlipController extends Controller
{
    protected $storageRoot_;
    protected $locale_;
    protected $chapterOnce_;
    
    public function __construct() {
        $this->txtRoot_= '/repository/story';
        $this->locale_='zh';
        $this->chapterOnce_=5;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($chapter = null)
    {
        //
        //Log::info($chapter);
        if($chapter < 1) {
            $chapter = 1;
        }
        $prev = $chapter -1;
        if( $prev < 1) {
            $prev = 1;
        }
        $titlePath = $this->txtRoot_ . '/' . $this->locale_ . '/' . $chapter . '/title';
        if( file_exists($titlePath) ) {
            $title = file_get_contents($titlePath);
        } else {
            $title = '???';
        }
        $cmd = 'find ' . $this->txtRoot_ . '/' . $this->locale_ . '/'. $chapter . '/s.*.txt' . ' -type f | sort -t / -k 8 -n';
        //Log::info($cmd);
        $output = shell_exec($cmd);
        //Log::info('$output=<' . $output . '>');
        $sections = explode("\n",$output);
        $contentAll ='';
        foreach ($sections as $value) {
            //Log::info('$value=<' . $value . '>');
            if( file_exists($value) ) {
                $sectionText = file_get_contents($value);
                $contentAll .= $sectionText;
            }
        }

        $cmd = 'find ' . $this->txtRoot_ . '/' . $this->locale_ . '/'. $chapter . '/a' . ' -type f ';
        //Log::info($cmd);
        $output = shell_exec($cmd);
        //Log::info('$output=<' . $output . '>');
        $sections = explode("\n",$output);
        $anim = array();
        foreach ($sections as $file) {
            //Log::info('$file=<' . $file . '>');
            if( file_exists($file) ) {
                $name = basename($file);
                $anim[] = $name;
            }
        }

        $data = ['prev' => $prev,'chapter' => $chapter,
                 'next' => $chapter +1,'title'=>$title,
                 'content'=>$contentAll,'anim'=>$anim];
        return view('story.slip',$data);
    }

}
