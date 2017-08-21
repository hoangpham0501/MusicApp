<!-- resources/views/auth/login.blade.php -->

@extends('master')

@section('title', 'Playlist')


@section('content')

  <div class="row">
    {{-- <div class="small-1  columns">sdfsd</div> --}}
    <div class="small-3 small-push-1 columns autoplay">
        <span>Autoplay <input type="checkbox" name="my-checkbox" checked/></span>
    </div>
    @if(Auth::check())
    <div class="small-8 end columns votes" id="votes">
        
    </div>
    @endif
  </div>
  <div id="playlist">

  </div>

  <!--PEN CODE-->
  <div id="player" class="player">
  	<span class="song_image"></span>
  	<div class="song_info">
  		<span id="player_song_title" class="song_title"></span>
      <span>-</span>
  		<span id="player_song_artist"  class="song_artist"></span>
  	</div>
    <!-- <div class="song_info">

  		<p id="player_song_artist"  class="song_artist"></p>
      <p id="player_song_title" class="song_title"></p>
  	</div> -->
  	<ul class="player_controls">
  		<li  class="player_play"><i id="player_play" class="fa fa-fw fa-play"></i></li>
  		<li  class="player_volume"><i id="player_volume" class="fa fa-fw fa-volume-up"></i></li>
  	</ul>
  	<span class="player_seeker">
        <span id="player_seeker" class="seeker_pos"></span>
  	</span>
  </div>

  <audio id="player_audio" preload autoplay="autoplay">
  	<!-- <source src="https://dl.dropboxusercontent.com/u/56960033/musicplayer/this-is-life.mp3" type="audio/mpeg"> -->
  </audio>


<!--END PEN CODE-->
  <script src="{{ URL::asset('js/bootstrap-switch.min.js') }}"></script>
  <script>
     $("[name='my-checkbox']").bootstrapSwitch();
  </script>
    <script>
        $(document).ready(function() {
            //remember autoplay state
            if(localStorage.getItem('state') === 'false') {
              $("[name='my-checkbox']").bootstrapSwitch('state', false);
            }
            $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function (event, state) {
              localStorage.setItem('state', state);  
            });

            //update song and vote views
            $.get("/songs", function( data ) {
                 $("#playlist").html( data );
            });
            $.get("/votes", function( data ) {
                 $("#votes").html( data );
             });

            //Player class
          	var player = {
          		DOM: function() {
          			//Song Details
          			this.songTitle = $("#player_song_title");
          			this.songAlbum = $("#player_song_album");
          			this.songArtist = $("#player_song_artist");
          			//Controls
          			this.playerPlay = $("#player_play");
          			this.playerPause = $("#player_pause");
          			this.playerVol = $("#player_volume");

                this.playerRange = $(".player_seeker");
          			this.playerSeeker = $("#player_seeker");
          			this.playerAudio = $("#player_audio");
          		},
          		events: function() {
          			this.playerPlay.on("click", this.playBtn.bind(this));
          			this.playerVol.on("click", this.muteBtn.bind(this));
                this.playerRange.on("click", this.adjustTime.bind(this));
          			this.playerAudio.on("ended", this.songEnded.bind(this));
          			this.playerAudio.on("timeupdate", this.progessPos.bind(this));
          		},
          		init: function() {
          			this.DOM();
          			this.events();
          		},
          		playBtn: function() {
                var url = $('#player_audio').attr('src'); 
                var icon = $("a[data-url='" + url + "']").find('i');
                if(document.getElementById('player_audio').paused) {
                // if(this.playerPlay.hasClass('fa-play')) {
                  this.playerPlay.removeClass('fa-play').addClass('fa-pause');

                  icon.removeClass('fa-play').addClass('fa-pause');
                  // this.playerAudio.trigger("play");
                  document.getElementById('player_audio').play();
                } else {
                  this.playerPlay.removeClass('fa-pause').addClass('fa-play');

                  icon.removeClass('fa-pause').addClass('fa-play');
                  // this.playerAudio.trigger("pause");
                  document.getElementById('player_audio').pause();
                }

          		},
          		muteBtn: function() {
          			var isMuted = this.playerAudio.prop("muted");
          			if (isMuted === true) {
          				this.playerAudio.prop("muted", false);
                  this.playerVol.removeClass('fa-volume-down').addClass('fa-volume-up');

                  // this.playerVolMuted.hide();
          			} else {
          				this.playerAudio.prop("muted", true);
                  this.playerVol.removeClass('fa-volume-up').addClass('fa-volume-down');
          				// this.playerVolMuted.show();
                  // this.playerVol.hide();
          			}
          		},
              getCur: function() {
                  var url = $('#player_audio').attr('src');
                  return $("a[data-url='" + url + "']").closest('tr').first().index();

              },
          		songEnded: function() {
          			//    console.log("song ended");

          			// this.playerAudio.trigger("pause");
          			// this.playerPause.hide();
          			// this.playerAudio.trigger("currentTime", 0);
          			// this.playerPlay.show();

                // var audio = document.getElementById('player_audio');
                // audio.currentTime = 0;

                 // if($(".bootstrap-switch").hasClass("bootstrap-switch-on")) {
                 //   // var next = this.getCur() + 2;
                 //   // console.log(next);0
                 //   // $('tr').eq(next).find('.control-btn').click();

                 //   var cur = this.getCur();
                 //   // console.log(cur);
                 //   var len = $('tr').length;
                 //   var randomNum = cur + 1;
                 //   while(randomNum != cur) {
                 //    randomNum = Math.floor( Math.random() * ( 1 + len - 1 ) ) + 1; 
                 //   }
                 //   console.log(randomNum);
                 //   $('tr').eq(randomNum).find('.control-btn').click();
                 // }


                // if autoplay is turn off    
                if(!($(".bootstrap-switch").hasClass("bootstrap-switch-on"))){
                    $('table').find('i').removeClass('fa-pause').addClass('fa-play');
                    return;
                }
            //else if turn on
            //find the next song to play
                var nextSong = 0;
                $('.control-btn').each(function(){
                    var thisIcon = $(this).find('i')[0];
                    if(!(thisIcon.className == 'fa fa-pause')){                        
                        nextSong++;
                    }else{
                        return false;
                    }
                });
                nextSong++;
            //end of the list -> back to play the song #0
                if(nextSong == $('.control-btn').size()){
                    nextSong = 0;
                }

                var fetcher = 0;
                $('.control-btn').each(function(){
                    if(fetcher == nextSong){
                        $(this).click();
                        return false;
                    }else{
                        fetcher++;
                    }
                });

          		},
          		progessPos: function(audio) {
          			audio = audio.currentTarget;
          			var dur = audio.duration,
          				curTime = audio.currentTime,
          				seekerPos = (curTime / dur) * 100;
          			this.playerSeeker.css("right", (100 - seekerPos) + "%");
          		},
              adjustTime: function(event) {
                var left = $(event.target).offset().left;
                var width = $('.player_seeker').first().width();
                var audio = document.getElementById('player_audio');
                // var dur = audio.duration;
                audio.currentTime = ((event.pageX - left)/width)*audio.duration;
              }
          	};

            $('#playlist').on('click', '.control-btn', function() {
                
                var songURL = $(this).data('url');
                var title = $(this).data('title');
                var artist = $(this).data('artist');

                console.log(songURL);

                $("#player_song_title").text($(this).data('title'));
                $("#player_song_artist").text($(this).data('artist'));
                // console.log($(this).closest().siblings().find('.title'))

                if($("#player_audio").attr('src') != songURL) {
                    $("#player_audio").attr('src', songURL);
                }

                // $("#player_play").removeClass('fa-play').addClass('fa-pause');

                var icon = $(this).find('i')[0];

                if(icon.className == 'fa fa-play') {
                 // if(!document.getElementById('player').paused) {
                    $('table').find('i').removeClass('fa-pause').addClass('fa-play');
                    $(icon).removeClass('fa-play').addClass('fa-pause');
                    $("#player_play").removeClass('fa-play').addClass('fa-pause');
                    // $('#player_play').click();
                    document.getElementById('player_audio').play();
                } else {
                    $(icon).removeClass('fa-pause').addClass('fa-play');
                    $("#player_play").removeClass('fa-pause').addClass('fa-play');
                    // $('#player_play').click();
                    document.getElementById('player_audio').pause();
                }
            })

            player.init();
        })
    </script>
@endsection
