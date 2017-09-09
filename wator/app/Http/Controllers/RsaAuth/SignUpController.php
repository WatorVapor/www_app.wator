<?php

namespace Wator\Http\Controllers\RsaAuth;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;
use File;

class SignUpController extends Controller
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
    public function index()
    {
        //
        var_dump($this->keyRoot_);
        return view('rsaauth.signup');
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
        //var_dump($bodyContent);
        $bodyJson = json_decode($bodyContent);
        //var_dump($bodyJson);
        $keyPath = $this->keyRoot_ . $bodyJson->token . '/';
        File::makeDirectory($keyPath, 0777, true, true);
        //var_dump($keyPath);
        file_put_contents($keyPath . '/pubKey.pem', $bodyJson->pubKey);
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
