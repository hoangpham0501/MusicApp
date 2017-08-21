<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Redirect;
use App\BlockedSongs;
use Session;
class AdminController extends Controller
{
    //

    public function getBlockSong(){
        return View::make('admin.blocksong');
    }

    public function postBlockSong(Request $request){
        $link_mp3 = $request->input('txt_linkMp3');
        $songName = $request->input('txt_songName');
        $word     = $request->input('txt_word');

        $message = "";

        //block by link_mp3
        if($link_mp3 != null && trim($link_mp3) != ""){
            $message .= self::BlockByLinkMp3($link_mp3);
        }

        //block by song name
        if($songName != null && trim($songName) != ""){
            $message .= self::BlockBySongName($songName);
        }
        
        //block by word
        if($word != null && trim($word) != ""){
            $message .= self::BlockByWord($word);
        }

        return Redirect::to('blockedSongList')->with('message', $message);
    }

    //@returns: bool true if the $song is blocked
    public function isBlockedSong($song){
        $listBlockedByLink = BlockedSongs::whereNotNull('link_mp3')->select('link_mp3')->get();
        $listBlockedBySongName = BlockedSongs::whereNotNull('title')->select('title')->get();
        $listBlockedByWord = BlockedSongs::whereNotNull('word')->select('word')->get();
        //check blocked by link
        foreach($listBlockedByLink as $key => $value){
            if(strtolower(trim($value['link_mp3'])) == strtolower(trim($song['link']))){
                return true;
            }
        }
        //check blocked by name
        foreach($listBlockedBySongName as $key => $value){
            if(strtolower(trim($value['title'])) == strtolower(trim($song['title']))){
                return true;
            }
        }
        //check blocked by word
        foreach($listBlockedByWord as $key => $value){
            if(strpos(strtolower(trim($song['title'])), strtolower($value['word'])) !== false){
                return true;
            }
        }

        return false; 
    }

    public function BlockByLinkMp3($link_mp3){
            //chi luu phan /bai-hat/... de mapping voi url tren API
        $pos = strpos($link_mp3, '/bai-hat/');
        $blockedLink = substr($link_mp3, $pos);
        $blockedSong = new BlockedSongs;
        $blockedSong->link_mp3 = $blockedLink;
        try{
            $blockedSong->save();
        }catch(\Illuminate\Database\QueryException $e){
            if(strpos($e->getMessage(), 'Duplicate entry') !== false){
                return "You have blocked this song already!<br/>";
            }else{
                return $e->getMessage();
            }
            
        } 
        
        return "Block by link mp3 successfully!<br/>";
    }

    public function BlockBySongName($songName){
        $blockedSong = new BlockedSongs;
        $blockedSong->title = $songName;
        try{
            $blockedSong->save();
        }catch(\Illuminate\Database\QueryException $e){
            return $e->getMessage();
        } 

        return "Block by song name successfully!<br/>";
    }

    public function BlockByWord($word){
        $blockedSong = new BlockedSongs;
        $blockedSong->word = $word;
        try{
            $blockedSong->save();
        }catch(\Illuminate\Database\QueryException $e){
            return $e->getMessage();
        } 
        return "Block by word successfully!<br/>";
    }

    public function getBlockedSongList(){
        $message = Session::get('message');
        $listBlockedByLink = BlockedSongs::whereNotNull('link_mp3')->get();
        $listBlockedBySongName = BlockedSongs::whereNotNull('title')->get();
        $listBlockedByWord = BlockedSongs::whereNotNull('word')->get();
        return View::make('admin.blockedSongList')
        ->with('listBlockedByLink', $listBlockedByLink)
        ->with('listBlockedBySongName', $listBlockedBySongName)
        ->with('listBlockedByWord', $listBlockedByWord)
        ->with('message', $message);
    }

    public function getUnblockSong(){
        $id = $_GET['id'];
        $unblocked = BlockedSongs::find($id);
        try{
            $unblocked->delete();
        }catch(Exception $e){
            return $e->getMessage();
        }
        return "success";
    }

}
