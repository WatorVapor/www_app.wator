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
        var_dump($lang);
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
                $phonemePath = storage_path() . '/RecordVoicePhoneme.json';
                var_dump($phonemePath);
                $phonemeStr = file_get_contents($phonemePath);
                $phonemeJson = json_decode($phonemeStr, true);
                
            }
            //var_dump($phonemeJson);
            if($phonemeJson[$lang]) {
                var_dump($phonemeJson[$lang]);
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
