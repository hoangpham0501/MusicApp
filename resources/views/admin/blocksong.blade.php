<!-- resources/views/auth/login.blade.php -->

@extends('master')

@section('title', 'Block song')


@section('content')

@if (Auth::check() and (Auth::user()->role=="admin"))
<div class="row">
    <div class="small-10 small-centered columns">
    
        <center><h3 class="page-header">Block Song</h3></center>        
        <form method="POST" action="{{ URL::to('blocksong') }}">
            {!! csrf_field() !!}
            <label>By direct link:</label>
            <input type="text" name="txt_linkMp3" placeholder="MP3 link to the song" />
            <label>By song name:</label>
            <input type="text" name="txt_songName" placeholder="Song name" />
            <label>By words (block songs which title contains this word):</label>
            <input type="text" name="txt_word" placeholder="Word to block" />
            <center><input type="submit" value="Block" class="button alert user_button"/>
            <input type="reset" value="Reset" class="button user_button"/></center>
        </form>

    </div>
</div>    
        
    <script>
        $(document).ready(function() {

        });
    </script>
    @else
    <h1 style="text-align:center;color: red; font-size: 70px; margin-top: 100px;">Oops!!! Login to continue</h1>
    @endif
@endsection


