<?php

namespace App\Http\Controllers;

use DB;
use App\Song;
use App\User;
use View;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SongController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
      $songs = DB::table('songs')
                    ->orderBy('position', 'desc')
                    ->leftJoin('users','add_by_user','=','users.id')
                    ->select('songs.*','users.id as user_id','users.name')
                    ->get();
      // $songs = Song::orderBy('position', 'desc')->get();

      // load the view and pass the nerds
      return View::make('song.index')
          ->with('songs', $songs);
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
          if(!Auth::check()){
            return 'Please login first!';
          }
          if(Auth::user()->status == "blocked"){
            return 'Your account was blocked!';
          }
          if(Song::where('song_id', $request->song['song_id'])->first() != null){
            return 'This song is in the list already!';
          }
          if((new AdminController)->isBlockedSong($request->song)){
            return 'This song is blocked';
          }

          $newSong = new Song;
          $newSong->song_id           = $request->song['song_id'];
          $newSong->title             = $request->song['title'];
          $newSong->artist            = $request->song['artist'];
          $newSong->genre             = $request->song['genre'];
          $newSong->username          = $request->song['username'];
          $newSong->bitrate           = $request->song['bitrate'];
          $newSong->duration          = $request->song['duration'];
          $newSong->have_rbt          = $request->song['have_rbt'];
          $newSong->download_status   = $request->song['download_status'];
          $newSong->copyright         = $request->song['copyright'];
          $newSong->artist_ids        = implode(" ", $request->song['artist_ids']);
          $newSong->link              = $request->song['link'];
          $newSong->total_play        = $request->song['total_play'];
          $newSong->link_download     = implode(" ", $request->song['link_download']);
          $newSong->source            = implode(" ", $request->song['source']);
          $newSong->lyrics_file       = $request->song['lyrics_file'];
          $newSong->add_by_user       = Auth::id();
          $newSong->timestamps        = true;
          $newSong->save();

          return response()->json(['id' => $newSong->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // $song = Song::find($id);
        $song = DB::table('songs')
                      ->where('songs.id', '=', $id)
                      ->leftJoin('users', 'add_by_user', '=', 'users.id')
                      ->select('songs.*', 'users.id as user_id', 'users.name')
                      ->first();
                      // ->get();
        // print_r($song);
        return view('song.show', ['song' => $song]);
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
         $song = Song::find($id);
         $song->position = $request->position;
         $song->save();

         return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
      $song = Song::find($id);
      $song->delete();

      return;
    }

}
