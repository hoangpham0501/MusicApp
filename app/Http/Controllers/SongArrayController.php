<?php

namespace App\Http\Controllers;

use DB;
use App\Song;
use App\Config;
use View;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SongArrayController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
      $duration = Config::first()->duration;
      $songs = DB::table('songs')
                    ->select('source')
                    ->orderBy('position', 'desc')
                    ->take($duration)
                    ->get();  
      $list = array();
      foreach ($songs as $song) {
        // print_r(songs)
        // print_r(explode(" ", $song->source)[0]);
        array_push($list, explode(" ", $song->source)[0]);
      }

      // print_r($list);
      return response()->json(['songarray' => $list]);

      // print_r(json_encode($list)) ;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {


      return;
    }

}
