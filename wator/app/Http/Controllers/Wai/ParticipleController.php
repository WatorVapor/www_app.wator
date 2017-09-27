<?php
namespace Wator\Http\Controllers\Wai;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;
class ParticipleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $response = session('wai_participle_cut_reponse');
        session()->forget('wai_participle_cut_reponse');
        //var_dump($response);
        $data = ['result'=>[]];
        if($response) {
            try {
                $jsonRes = json_decode($response,true);
                //var_dump($jsonRes);
                $data = ['result'=>$jsonRes['wai']];
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        }
        $text = session('wai_participle_cut_text');
        if($text) {
            $data['text'] = $text;
        } else {
            $data['text'] = '';
        }
        $staticHTML = view('wai.participle',$data)->__toString();
        $htmlFileName = hash($staticHTML,"sha256") . '.html';
        file_put_contents('/autogen/wator/wai/static/' . $htmlFileName,$staticHTML);
        return view('wai.participle',$data);
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
        try {
            $sentence = $request->input('sentence');
            $msgJson = ['lang' => 'cn'];
            $lang = $request->input('lang');
            //var_dump($lang);
            if(isset($lang) && $lang == 'ja') {
                $msgJson['lang'] = 'ja';
            }
            $msg = json_encode($msgJson);
            $request->session()->put('wai_participle_cut_text', $sentence);
            //var_dump($sentence);
            $apiStr = file_get_contents('/nativeapi/wai.conf.api.json');
            //var_dump($apiStr);
            $apiJson = json_decode($apiStr,true);
            //var_dump($apiJson);
            $waiPort = intval($apiJson['port']);;
            //var_dump($waiPort);
            $sock = socket_create(AF_INET6, SOCK_DGRAM, SOL_UDP);
            //var_dump($sock);
            socket_set_option($sock,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>5,"usec"=>0));
            $result = socket_connect($sock, '::1', $waiPort);
            socket_write($sock, $msg, strlen($msg));
            socket_write($sock, $sentence, strlen($sentence));
            $buf = '...';
            $bytes = socket_recv($sock, $buf, 1024*1024, MSG_WAITALL);
            //var_dump($bytes);
            //var_dump($buf);
            socket_close($sock);
            $request->session()->put('wai_participle_cut_reponse', $buf);
        } catch (\Exception $e) {
            $request->session()->put('wai_participle_cut_reponse', $e->getMessage());
        }
        return redirect()->back();
    }
}
