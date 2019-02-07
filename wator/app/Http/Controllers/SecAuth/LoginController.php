<?php

namespace Wator\Http\Controllers\SecAuth;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;
use File;

class LoginController extends Controller
{
    protected $keyRoot_;
    public function __construct() {
        $this->keyRoot_ = '/opt/secauth/pubKeys/';
        File::makeDirectory($this->keyRoot_, 0775, true, true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$auto = null)
    {
        //var_dump($auto);
        //
        $request->session()->forget('account.sec.login.status');
        $request->session()->forget('account.sec.login.name');
        $request->session()->forget('account.sec.login.token');
        $request->session()->forget('account.sec.login.access');
        $request->session()->forget('account.sec.login.redirecting');
        $strRequest = uniqid();
        //var_dump($strRequest);
        $id  = hash('sha256',$strRequest);
        $request->session()->put('account.sec.login.access',$id);
        $autoFlags = 'false';
        return view('secauth.login',['SecLoginAccessKey'=>$id,'auto'=> $autoFlags]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function auto_login(Request $request)
    {
        //var_dump($auto);
        //
        $request->session()->forget('account.sec.login.status');
        $request->session()->forget('account.sec.login.name');
        $request->session()->forget('account.sec.login.token');
        $request->session()->forget('account.sec.login.access');
        $request->session()->forget('account.sec.login.redirecting');
       $strRequest = uniqid();
        //var_dump($strRequest);
        $id  = hash('sha256',$strRequest);
        $request->session()->put('account.sec.login.access',$id);
        $autoFlags = 'true';
        return view('secauth.login_auto',['SecLoginAccessKey'=>$id,'auto'=> $autoFlags]);
    }

    /**
     * auto_store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function auto_store(Request $request)
    {
        try {
            //$input = $request->all();
            //var_dump($input);
            $accessToken = $request->input('accessToken');
            //var_dump($accessToken);
            $access = $request->input('access');
            //var_dump($access);
            $signature = $request->input('signature');
            //var_dump($signature);
            $keyPath = $this->keyRoot_ . $accessToken . ''. '/pubKey.b58';
            //var_dump($keyPath);
            if (file_exists($keyPath)) {
                //var_dump($keyPath);
                $ecdsaURI = 'http://127.0.0.1:17263/' . $accessToken . '/' . $access . '/' . $signature;
                //var_dump($ecdsaURI);
                $ecdsaVerifyStr = file_get_contents($ecdsaURI);
                //var_dump($ecdsaVerifyStr);
                $ecdsaVerify = json_decode($ecdsaVerifyStr);
                //var_dump($ecdsaVerify);
                if($ecdsaVerify && $ecdsaVerify->good) {
                    //var_dump($ecdsaVerify->good);
                    $request->session()->put('account.sec.login.status','success');
                    $request->session()->put('account.sec.login.token',$accessToken);
                    $request->session()->put('account.sec.login.access',$access);
                    $profilePath = $this->keyRoot_ . $accessToken . ''. '/profile';
                    if (file_exists($profilePath)) {
                        $profileStr = file_get_contents($profilePath);
                        $profileJson = json_decode($profileStr, true);
                        if(isset($profileJson['user_name'])) {
                            $request->session()->put('account.sec.login.name',$profileJson['user_name']);
                        } else {
                            $request->session()->forget('account.sec.login.name');
                        }
                    } else {
                        $request->session()->forget('account.sec.login.name');
                    } 
                } else {
                    $request->session()->put('account.sec.login.status','failure');
                    $request->session()->put('account.sec.login.token',$accessToken);
                    $request->session()->put('account.sec.login.access',$access);
                    //return response()->json(['status'=>'failure']);
                    $request->session()->put('account.sec.login.redirecting','yes');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            //var_dump($e);
            $request->session()->put('account.sec.login.status','failure');
            $request->session()->forget('account.sec.login.token');
            $request->session()->forget('account.sec.login.access');
            $request->session()->forget('account.sec.login.name');
            $request->session()->put('account.sec.login.redirecting','yes');
            //return response()->json(['status'=>'failure']);
            return redirect()->back()->back();
            //return redirect()->secure('/logi');
       }
       //return response()->json(['status'=>'success']);
       //return redirect()->back();
       return redirect()->secure('/');
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
        try {
            //$input = $request->all();
            //var_dump($input);
            $accessToken = $request->input('accessToken');
            //var_dump($accessToken);
            $access = $request->input('access');
            //var_dump($access);
            $signature = $request->input('signature');
            //var_dump($signature);
            if(!isset($accessToken) || !isset($access) || !isset($signature)) {
                $bodyContent = $request->getContent();
                $bodyJson = json_decode($bodyContent);
                $accessToken = $bodyJson->accessToken;
                $access = $bodyJson->access;
                $signature = $bodyJson->signature;
            }
            //var_dump($accessToken);
            //var_dump($access);
            //var_dump($signature);
            $keyPath = $this->keyRoot_ . $accessToken . ''. '/pubKey.b58';
            //var_dump($keyPath);
            if (file_exists($keyPath)) {
                //var_dump($keyPath);
                $ecdsaURI = 'http://127.0.0.1:17263/' . $accessToken . '/' . $access . '/' . $signature;
                //var_dump($ecdsaURI);
                $ecdsaVerifyStr = file_get_contents($ecdsaURI);
                //var_dump($ecdsaVerifyStr);
                $ecdsaVerify = json_decode($ecdsaVerifyStr);
                //var_dump($ecdsaVerify);
                if($ecdsaVerify && $ecdsaVerify->good) {
                    //var_dump($ecdsaVerify->good);
                    $request->session()->put('account.sec.login.status','success');
                    $request->session()->put('account.sec.login.token',$accessToken);
                    $request->session()->put('account.sec.login.access',$access);
                    $profilePath = $this->keyRoot_ . $accessToken . ''. '/profile';
                    if (file_exists($profilePath)) {
                        $profileStr = file_get_contents($profilePath);
                        $profileJson = json_decode($profileStr, true);
                        if(isset($profileJson['user_name'])) {
                            $request->session()->put('account.sec.login.name',$profileJson['user_name']);
                        } else {
                            $request->session()->forget('account.sec.login.name');
                        }
                    } else {
                        $request->session()->forget('account.sec.login.name');
                    } 
                } else {
                    $request->session()->put('account.sec.login.status','failure');
                    $request->session()->put('account.sec.login.token',$accessToken);
                    $request->session()->put('account.sec.login.access',$access);
                    //return response()->json(['status'=>'failure']);
                    //return redirect()->back()->back();
                }
            }
        } catch (\Exception $e) {
            //var_dump($e);
            $request->session()->put('account.sec.login.status','failure');
            $request->session()->forget('account.sec.login.token');
            $request->session()->forget('account.sec.login.access');
            $request->session()->forget('account.sec.login.name');
            //return response()->json(['status'=>'failure']);
            //return redirect()->back()->back();
       }
       //return response()->json(['status'=>'success']);
       //return redirect()->back()->back();
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
