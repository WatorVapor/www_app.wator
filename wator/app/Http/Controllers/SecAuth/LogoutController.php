<?php
namespace Wator\Http\Controllers\SecAuth;
use Wator\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;

class LogoutController extends Controller
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
        return view('secauth.logout');
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
        $request->session()->forget('account.sec.login.status');
        $request->session()->forget('account.sec.login.name');
        $request->session()->forget('account.sec.login.token');
        $request->session()->forget('account.sec.login.access');
        $request->session()->forget('account.sec.login.redirecting');
        //return redirect()->back();
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
