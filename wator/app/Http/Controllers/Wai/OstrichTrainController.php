<?php

namespace Wator\Http\Controllers\Wai;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OstrichTrainController extends Controller
{
    public function fetchTask($msgJson) {
        //
        try {
            $apiStr = file_get_contents('/nativeapi/train.ostrich.fetch.api.json');
            //var_dump($apiStr);
            $apiJson = json_decode($apiStr,true);
            //var_dump($apiJson);
            $waiPort = intval($apiJson['port']);;
            //var_dump($waiPort);
            $sock = socket_create(AF_INET6, SOCK_DGRAM, SOL_UDP);
            //var_dump($sock);
            socket_set_option($sock,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>5,"usec"=>0));
            $result = socket_connect($sock, '::1', $waiPort);
            $msg = json_encode($msgJson);
            socket_write($sock, $msg, strlen($msg));
            $buf = '...';
            $bytes = socket_recv($sock, $buf, 1024*1024, MSG_WAITALL);
            //var_dump($bytes);
            //var_dump($buf);
            socket_close($sock);
            return $buf;
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        return '';
    }
    
    public function fetch($tag)
    {
        try
        {
            $num = rand(1,100);
            //var_dump($num);
            //var_dump($tag);
            if($num %1 == 0) {
                $task = [
                    'url'=>'https://zh.wikipedia.org/zh-cn/%E4%B8%AD%E5%8D%8E%E4%BA%BA%E6%B0%91%E5%85%B1%E5%92%8C%E5%9B%BD',
                    'lang'=>'cn',
                    'type'=>'ostrich',
                    'tag'=>$tag
                ];
                $url = $this->fetchTask(['type'=>'ostrich','lang'=>'cn']);
                if($url){
                    $task['url'] = $url;
                    return  response()->json($task);
                }
                return  response()->json($task);
            } else {
                $task = [
                    'url'=>'https://ja.wikipedia.org/wiki/%E3%82%A2%E3%82%B9%E3%83%A9%E3%83%86%E3%83%83%E3%82%AF',
                    'lang'=>'ja',
                    'type'=>'ostrich',
                    'tag'=>$tag
                ];
                $url = $this->fetchTask(['type'=>'ostrich','lang'=>'ja']);
                if($url){
                    $task['url'] = $url;
                    return  response()->json($task);
                }
                return  response()->json($task);
            }
        } catch (\Exception $e) {
            var_dump($e);
        }
        $task = [ 'success' => false ];
        return  response()->json($task);
    }
    public function update(Request $request,$tag)
    {
        try
        {
            //$data = $request->all();
            //var_dump($data);
            $file = $request->file('file');
            //var_dump($file);
            $path = $file->path();
            //var_dump($path);
            $strURL = file_get_contents($path);
            //var_dump($strURL);
            
            $apiStr = file_get_contents('/nativeapi/train.ostrich.save.api.json');
            //var_dump($apiStr);
            $apiJson = json_decode($apiStr,true);
            //var_dump($apiJson);
            $waiPort = intval($apiJson['port']);;
            var_dump($waiPort);
            $sock = socket_create(AF_INET6, SOCK_DGRAM, SOL_UDP);
            //var_dump($sock);
            socket_set_option($sock,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>20,"usec"=>0));
            $result = socket_connect($sock, '::1', $waiPort);
            socket_write($sock, $strURL, strlen($strURL));
            $buf = '...';
            $bytes = socket_recv($sock, $buf, 1024*1024, MSG_WAITALL);
            //var_dump($bytes);
            var_dump($buf);
            socket_close($sock);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        $res = [ 'success' => true ];
        return  response()->json($res,200,[],JSON_PRETTY_PRINT);
    }
    public function summary() {
        //
        try {
            $apiStr = file_get_contents('/nativeapi/train.ostrich.fetch.api.json');
            //var_dump($apiStr);
            $apiJson = json_decode($apiStr,true);
            //var_dump($apiJson);
            $waiPort = intval($apiJson['port']);;
            //var_dump($waiPort);
            $sock = socket_create(AF_INET6, SOCK_DGRAM, SOL_UDP);
            //var_dump($sock);
            socket_set_option($sock,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>5,"usec"=>0));
            $result = socket_connect($sock, '::1', $waiPort);
            
            $msgJson = ['type'=>'ostrich','summary' => 'get' ];
            $msg = json_encode($msgJson);
            socket_write($sock, $msg, strlen($msg));
            $buf = '...';
            $bytes = socket_recv($sock, $buf, 1024*1024, MSG_WAITALL);
            //var_dump($bytes);
            //var_dump($buf);
            socket_close($sock);
            $task = ['summary' => $buf];
            return view('wai.summary',$task);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        return view('wai.summary',['summary' => '']);
    }
}
