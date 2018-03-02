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
    
    protected $phonemeArray_ = [];
    public function fetchTrainData(Request $request,$lang) {
        /*
        if(isset($this->phonemeArray_[$lang])) {
            return $this->phonemeArray_[$lang];
        }
        */
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
        $this->phonemeArray_[$lang] = $phonemeJson;
        return $phonemeJson;
     }
    public function saveTrainData(Request $request,$lang,$phonemeJson) {
        $accessToken = $request->session()->get('account.rsa.login.token');
        $profilePath = $this->keyRoot_ . $accessToken . ''. '/wai';
        File::makeDirectory($profilePath, 0775, true, true);
        $phonemePath = $profilePath . '/phoneme_' . $lang . '.json';
        $phonemeData = json_encode($phonemeJson,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $result = file_put_contents($phonemePath,$phonemeData);
        return $result;
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
           //var_dump($phonemeJson);
            $phonemeJson = $this->fetchTrainData($request,$lang);
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
                if($finnish == count($phonemeJson[$lang])) {
                    $data['phoneme'] = ' ';
                    $data['phoneme_help'] = ' ';
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
        $accessToken = $request->session()->get('account.rsa.login.token');
        var_dump($accessToken);
        $phoneme = $request->input('phoneme');
        //var_dump($phoneme);
        $langPhoneme = $request->input('lang');
        //var_dump($langPhoneme);
        $ipfs = $request->input('ipfs');
        //var_dump($ipfs);
        /*
        $hidden_data = $request->input('hidden_data');
        var_dump($hidden_data);
        $file = $request->file();
        var_dump($file);
        */

        try {
            $phonemeJson = $this->fetchTrainData($request,$lang);
            if(isset($phoneme)) {
                foreach( $phonemeJson[$lang] as $key => $value ) {
                   //var_dump($value);
                    if($value['phoneme'] == $phoneme){
                        $phonemeJson[$lang][$key]['train'] = true;
                        //var_dump($phonemeJson[$lang][$key]);
                        $result = $this->saveTrainData($request,$lang,$phonemeJson);
                        //var_dump($result);
                        break;
                    }
                }
            }
            if(isset($ipfs)) {
                $ipfsJson = json_decode($ipfs, true);
                //var_dump($ipfsJson);
                foreach( $ipfsJson as $value ) {
                    var_dump($value);
                    $lang = $value['lang'];
                    $phoneme = $value['phoneme'];
                    $ipfsHash = $value['ipfs'];
                    $phonemeJson = $this->fetchTrainData($request,$lang);
                    foreach( $phonemeJson[$lang] as $key => $value ) {
                       //var_dump($value);
                        if($value['phoneme'] == $phoneme){
                            $phonemeJson[$lang][$key]['ipfs'] = $ipfsHash;
                            //var_dump($phonemeJson[$lang][$key]);
                            $result = $this->saveTrainData($request,$lang,$phonemeJson);
                            //var_dump($result);
                            break;
                        }
                    }
                }
            }
        } catch( \Exception $e ) {
            var_dump($e->getMessage());
        }
        return redirect()->back();
        //return response()->json(['status'=>'success']);
    }
}
