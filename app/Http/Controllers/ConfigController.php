<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Config;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class ConfigController extends Controller
{
    protected $redirectTo = '/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()) {
           $config = Config::first();
           $start_time = $config->start_time;
                    $duration = $config->duration;
                    $option = $config->option;

        return view("admin/config")->with([
            'start_time' => $start_time,
            'duration' => $duration,
            'option'=>$option
        ]);
        }
        else return view('admin/config');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
             'start_time' => 'required|max:255',
            'duration' => 'required|max:255',
            'option' => 'required|max:255',
        ]);
    }


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
        $cf = Config::first();
        $cf->start_time = $request->input('start_time');
        $cf->duration = $request->input('duration');
        $cf->option = $request->input('option');
        $cf->save();
        return view("admin/config")->with([
                 'start_time' => $cf->start_time,
                'duration' => $cf->duration,
                'option'=> $cf->option
                ]);
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
