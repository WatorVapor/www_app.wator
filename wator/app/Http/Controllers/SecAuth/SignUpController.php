<?php

namespace Wator\Http\Controllers\SecAuth;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;
use File;

class SignUpController extends Controller
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
    public function index()
    {
        //
        //var_dump($this->keyRoot_);
        return view('secauth.signup');
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
        $accountKeyId = $request->input('accountKeyId');
        var_dump($accountKeyId);
        $accountToken = $request->input('accountToken');
        var_dump($accountToken);
        if($accountKeyId && $accountToken) {
          $keyPath = $this->keyRoot_ . $accountKeyId . '/';
          File::makeDirectory($keyPath, 0777, true, true);
          var_dump($keyPath);
          file_put_contents($keyPath . '/pubKey.b58', $accountToken);
        }
        return redirect()->secure('/secauth/profile');
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_auto_create()
    {
        //
        //var_dump($this->keyRoot_);
        return view('secauth.signup_auto_create');
    }

}
