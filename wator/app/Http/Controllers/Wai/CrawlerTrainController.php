<?php

namespace Wator\Http\Controllers\Wai;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CrawlerTrainController extends Controller
{
    public function fetchTask($msgJson) {
        //
        try {
            $apiStr = file_get_contents('/watorvapor/wai.storage/conf/url.fetch.api.json');
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
    public function fetch()
    {
        try
        {
            $num = rand(0,100);
            //var_dump($num);
            if($num %2 == 0) {
                $task = [
                    'url'=>'https://zh.wikipedia.org/zh-cn/%E7%94%B5%E5%AD%90',
                    'lang'=>'cn',
                    'base_url'=>'https://zh.wikipedia.org',
                    'filter'=>'/wiki/',
                    'prefix'=>'/zh-cn/'
                ];
                $url = $this->fetchTask(['type'=>'crawler','lang'=>'cn']);
                if($url){
                    $task['url'] = $url;
                    return  response()->json($task);
                }
            } else {
                $task = [
                    'url'=>'https://ja.wikipedia.org/wiki/%E3%82%A2%E3%82%B9%E3%83%A9%E3%83%86%E3%83%83%E3%82%AF',
                    'lang'=>'ja',
                    'base_url'=>'https://ja.wikipedia.org',
                    'filter'=>'/wiki/',
                    'prefix'=>'/wiki/'
                ];
                $url = $this->fetchTask(['type'=>'crawler','lang'=>'ja']);
                if($url){
                    $task['url'] = $url;
                    return  response()->json($task);
                }
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        $task = [ 'success' => false ];
        return  response()->json($task);
    }
    public function update(Request $request)
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
            
            $apiStr = file_get_contents('/watorvapor/wai.storage/conf/url.save.api.json');
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
            $apiStr = file_get_contents('/watorvapor/wai.storage/conf/url.fetch.api.json');
            //var_dump($apiStr);
            $apiJson = json_decode($apiStr,true);
            //var_dump($apiJson);
            $waiPort = intval($apiJson['port']);;
            //var_dump($waiPort);
            $sock = socket_create(AF_INET6, SOCK_DGRAM, SOL_UDP);
            //var_dump($sock);
            socket_set_option($sock,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>30,"usec"=>0));
            $result = socket_connect($sock, '::1', $waiPort);
            
            $msgJson = ['summary' => 'get' ];
            $msg = json_encode($msgJson);
            socket_write($sock, $msg, strlen($msg));
            $buf = '...';
            $bytes = socket_recv($sock, $buf, 1024*1024, MSG_WAITALL);
            //var_dump($bytes);
            //var_dump($buf);
            socket_close($sock);
            $task = ['summary' => $buf];
            return view('text.summary',$task);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        return view('text.summary',['summary' => '']);
    }
}
