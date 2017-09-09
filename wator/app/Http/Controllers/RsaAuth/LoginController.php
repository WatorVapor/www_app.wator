<?php

namespace Wator\Http\Controllers\RsaAuth;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Log;
use File;

class LoginController extends Controller
{
    protected $keyRoot_;
    public function __construct() {
        $this->keyRoot_ = storage_path() . '/pubKeys/';
        File::makeDirectory($this->keyRoot_, 0775, true, true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
       $bodyContent = $request->getContent();
        //Log::info($bodyContent);
        $bodyJson = json_decode($bodyContent);
        if(!isset($bodyJson->token)) {
            unset($_SESSION['account.rsa.login.status']);
            return response()->json(['status'=>'success']);
        }
        //Log::info('$bodyJson->token=<' . $bodyJson->token . '>');
        $keyPath = $this->keyRoot_ . $bodyJson->token . ''. '/pubKey.pem';
        //Log::info('$keyPath=' . $keyPath);
        $fp = fopen($keyPath, 'r');
        $pubKeyMem = fread($fp, 8192);
        fclose($fp);
        $pubkeyid = openssl_pkey_get_public($pubKeyMem);
        //Log::info('$pubkeyid=' . $pubkeyid);
        try {
            $access = $bodyJson->auth->access;
            $sign = $bodyJson->auth->sign;
            $ok = openssl_verify($access,hex2bin($sign) , $pubkeyid,"sha256");
            openssl_free_key($pubkeyid);
            if ($ok == 1) {
                $_SESSION['account.rsa.login.status'] = 'success';
                $profilePath = $this->keyRoot_ . $bodyJson->token . ''. '/profile';
                if (file_exists($profilePath)) {
                    $profileStr = file_get_contents($profilePath);
                    $profileJson = json_decode($profileStr, true);
                    $_SESSION['account.rsa.login.name'] = $profileJson['user'];
                    Log::info('$profileJson->user=<' . $profileJson['user'] . '>');
                    return response()->json(['status' => 'success']);
                } else {
                    $_SESSION['account.rsa.login.name'] = 'unknow';
                    Log::info('unknow');
                    return response()->json(['status' => 'success']);
                }                    
            } elseif ($ok == 0) {
                $_SESSION['account.rsa.login.status'] = 'failure';
                Log::info('failure>');
                return response()->json(['status' => 'failure']);
            } else {
                $_SESSION['account.rsa.login.status'] = 'failure';
                Log::info('failure>');
                return response()->json(['status' => 'failure']);
            }
        } catch (Exception $e) {
            $_SESSION['account.rsa.login.status'] = 'failure';
            Log::info($e);
            return response()->json(['status'=>'failure']);
        }
        //Log::info($bodyJson->token);
        //Log::info($bodyJson->sign);
        return response()->json(['status'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
