<?php
namespace Wator\Http\Controllers\Wai;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;


use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Redis;


class RecordVoiceController extends Controller
{
    use Notifiable;
    
    protected const $PHONEME_ = [
       'ja' => [
           ['phoneme'=>'あ','phoneme_help'=>'阿'],
           ['phoneme'=>'い','phoneme_help'=>'一'],
           ['phoneme'=>'う','phoneme_help'=>'巫'],
           ['phoneme'=>'え','phoneme_help'=>'诶'],
           ['phoneme'=>'お','phoneme_help'=>'凹'],

           ['phoneme'=>'か','phoneme_help'=>'喀'],
           ['phoneme'=>'き','phoneme_help'=>'剋'],
           ['phoneme'=>'く','phoneme_help'=>'哭'],
           ['phoneme'=>'け','phoneme_help'=>'开'],
           ['phoneme'=>'こ','phoneme_help'=>'考'],

           ['phoneme'=>'か','phoneme_help'=>'喀'],
           ['phoneme'=>'き','phoneme_help'=>'剋'],
           ['phoneme'=>'く','phoneme_help'=>'哭'],
           ['phoneme'=>'け','phoneme_help'=>'开'],
           ['phoneme'=>'こ','phoneme_help'=>'考'],
           
           ['phoneme'=>'りゃ','phoneme_help'=>'俩'],
           ['phoneme'=>'りゅ','phoneme_help'=>'遛'],
           ['phoneme'=>'りょ','phoneme_help'=>'聊']
       ],
        'cn' => [
        ]
    ] ;
    protected $keyRoot_;
    public function __construct() {
          $this->keyRoot_ = '/opt/rsaauth/pubKeys/';
          File::makeDirectory($this->keyRoot_, 0775, true, true);
    }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        try {
            $accessToken = $request->session()->get('account.rsa.login.token');
            $profilePath = $this->keyRoot_ . $accessToken . ''. '/wai';
            File::makeDirectory($profilePath, 0775, true, true);
            $phonemePath = $profilePath . '/phoneme.json';
            if (file_exists($phonemePath)) {
                $phonemeStr = file_get_contents($phonemePath);
                $phonemeJson = json_decode($phonemeStr, true);
            } else {
                
            }
        } catch( \Exception $e ) {
            var_dump($e->getMessage());
        }
        //var_dump($data);
        return view('wai.recorder_voice',$data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        var_dump($request);
/*        
        var_dump($request->input());
        $filename = $request->input('filename');
        var_dump($filename);
        $audio = $request->input('audio');
        var_dump($audio);
*/
        return response()->json(['status'=>'success']);
    }
}
