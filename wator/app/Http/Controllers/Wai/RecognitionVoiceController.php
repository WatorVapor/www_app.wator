<?php
namespace Wator\Http\Controllers\Wai;
use Wator\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Redis;
use File;
class RecognitionVoiceController extends Controller
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
    public function index(Request $request)
    {
        $data = [];
        //var_dump($data);
        return view('wai.recognition_voice',$data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->back();
        //return response()->json(['status'=>'success']);
    }
}
