<?php

namespace Wator\Http\Controllers\SecAuth;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;
use File;

class ProfileController extends Controller
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
    public function index(Request $request)
    {
        //
        $data = array();
        $data['user_icon'] = 'https://';
        $data['user_type'] = 'meat';
        $data['user_free'] = 'I am a good man!';
        $data['user_name'] = 'Nick Name';
        
        $accessId = $request->session()->get('account.sec.login.id');
        $data['user_id'] = $accessId;
        $profilePath = $this->keyRoot_ . $accessId . ''. '/profile';
        //var_dump($profilePath);
        if (file_exists($profilePath)) {
            $profileStr = file_get_contents($profilePath);
            $profileJson = json_decode($profileStr, true);
            //var_dump($profileJson);
            $profileJson['user_id'] = $accessId;
            return view('secauth.profile',$profileJson);
        }
        return view('secauth.profile',$data);
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
        $accessId = $request->session()->get('account.sec.login.id');
        //var_dump($accessId);
        $user_name = $request->input('user-name');
        //var_dump($user_name);
        $profilePath = $this->keyRoot_ . $accessId . '/profile';
        file_put_contents($profilePath, json_encode(['user_name'=>$user_name]));
        $request->session()->put('account.sec.login.name',$user_name);
        return redirect()->back();
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
