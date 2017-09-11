<?php

namespace Wator\Http\Controllers\RsaAuth;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;
use File;

class ProfileController extends Controller
{
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
        //
        $data = array();
        $data['user_name'] = 'Nick Name';
        $data['user_icon'] = 'https://';
        $data['user_type'] = 'meat';
        $data['user_free'] = 'I am a good man!';
        
        $accessToken = $request->session()->get('account.rsa.login.token');
        $profilePath = $this->keyRoot_ . $accessToken . ''. '/profile';
        var_dump($profilePath);
        if (file_exists($profilePath)) {
            $profileStr = file_get_contents($profilePath);
            $profileJson = json_decode($profileStr, true);
            var_dump($profileJson);
            return view('rsaauth.profile',$profileJson);
        }
        return view('rsaauth.profile',$data);
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
        $accessToken = $request->session()->get('account.rsa.login.token');
        var_dump($accessToken);
        $user_name = $request->input('user-name');
        var_dump($user_name);
        $profilePath = $this->keyRoot_ . $accessToken . '/profile';
        file_put_contents($profilePath, json_encode(['user_name'=>$user_name]));
        return redirect()->action('RsaAuth\ProfileController@index');
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
