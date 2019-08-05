<?php

namespace Wator\Http\Controllers\SecAuth;
//namespace Wator\Http\Controllers;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App;


class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $lang = $request->input('lang');
        //var_dump($lang);
        if($lang) {
            //var_dump($lang);
            $request->session()->put('user.operation.lang',$lang);
            App::setLocale($lang);
        }
        //return;
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

    /**
     * lang .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function lang(Request $request,$lang)
    {
        var_dump($lang);
        if($lang) {
            //var_dump($lang);
            $request->session()->put('user.operation.lang',$lang);
            App::setLocale($lang);
        }
       return redirect()->back();
    }


}
