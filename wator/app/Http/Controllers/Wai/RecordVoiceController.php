<?php
namespace Wator\Http\Controllers\Wai;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;


use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Redis;
use File;

class RecordVoiceController extends Controller
{
    use Notifiable;
    
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
    public function index(Request $request,$lang='cn')
    {
        //var_dump($lang);
        $data = [];
        try {
            $accessToken = $request->session()->get('account.rsa.login.token');
            $profilePath = $this->keyRoot_ . $accessToken . ''. '/wai';
            File::makeDirectory($profilePath, 0775, true, true);
            $phonemePath = $profilePath . '/phoneme_' . $lang . '.json';
            if (file_exists($phonemePath)) {
                $phonemeStr = file_get_contents($phonemePath);
                $phonemeJson = json_decode($phonemeStr, true);
            } else {
                $phonemePath = storage_path() . '/RecordVoicePhoneme_'. $lang . '.json';
                //var_dump($phonemePath);
                $phonemeStr = file_get_contents($phonemePath);
                $phonemeJson = json_decode($phonemeStr, true);
            }
            //var_dump($phonemeJson);
            if($phonemeJson[$lang]) {
                //var_dump($phonemeJson[$lang]);
                $finnish = 0;
                foreach( $phonemeJson[$lang] as $key => $value ) {
                    //var_dump($key);
                    //var_dump($value);
                    if(!isset($value['train'])) {
                        if(!isset($data['phoneme'])) {
                            $data['phoneme'] = $value['phoneme'];
                            $data['phoneme_help'] = $value['cn_help'];
                        }
                    } else {
                        $finnish += 1;
                    }
                }
                $data['total']  = count($phonemeJson[$lang]);
                $data['finnish']  = $finnish;
            }
            if($lang == 'cn') {
                $data['duration'] = 0.4;
            }
            if($lang == 'ja') {
                $data['duration'] = 0.2;
            }
            $data['lang'] = $lang;
        } catch( \Exception $e ) {
            $data['phoneme'] = ' ';
            $data['phoneme_help'] = ' ';
            $data['duration'] = 0.4;
            $data['lang'] = $lang;
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
    public function store(Request $request,$lang='cn')
    {
        $phoneme = $request->input('phoneme');
        var_dump($phoneme);
        $langPhoneme = $request->input('lang');
        var_dump($langPhoneme);
        $ipfs = $request->input('ipfs');
        var_dump($ipfs);
        return response()->json(['status'=>'success']);
    }
}
