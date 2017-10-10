<?php

namespace Wator\Http\Controllers\PPio;
use Wator\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WorldEntryController extends Controller
{
    protected $seedRoot_;
    public function __construct() {
        $this->seedRoot_ = storage_path() . '/seeds.json';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $seeds = []; 
        if (file_exists($this->seedRoot_)) {
            $seedStr = file_get_contents($this->seedRoot_);
            $seeds = json_decode($seedStr, true);
        } else {
            $seeds['seed']= []; 
        }
        return response()->json($seeds);
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
        //var_dump($request);
        //Log::debug($request);
        //Log::debug($request->ip());
        //Log::debug($request->server('HTTP_X_REAL_IP'));
        $rhost = $request->server('HTTP_X_REAL_IP');
        $rport = $request['port'];
        $rnode = $request['node'];
        
        $seeds = []; 
        if (file_exists($this->seedRoot_)) {
            $seedStr = file_get_contents($this->seedRoot_);
            $seeds = json_decode($seedStr, true);
        } else {
            $seeds['seed']= []; 
        }
        $seeds['seed'][$rnode] = [ 'host' => $rhost,'port' => $rport ];
        Log::debug($seeds);
        file_put_contents($this->seedRoot_, json_encode($seeds));
        return response()->json($seeds);
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
        //var_dump($id);
        Log::debug($id);
    }
}
