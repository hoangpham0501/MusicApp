function addSong(id) {
    $.get("songs/" + id, function(data) {
        $("#list").append(data);
    });
}

function moveSong(id) {
    $.get("/songs", function(data) {
        $("#playlist").html(data);
    });

    // $('#' + id).insertBefore($('#' + id).prev());
}

function removeSong(id) {
    console.log(id);
    $('#' + id).remove();
}


$(document).ready(function() {

    var songlist = [];

    $("#txt_search").keypress(function(e) {
        if (e.which == 13) {
            $('#btn_search').click();
        }
    });


    //Search
    $('#btn_search').on('click', function() {
        // $('#txt_search').on('keyup', function(){
        $('#result').empty();
        keyword = $('#txt_search').val();
        $.ajax({
            url: 'http://api.mp3.zing.vn/api/mobile/search/song?requestdata={"length":5,"start":0,"q":"' + keyword + '","sort":"hot"}&keycode=b319bd16be6d049fdb66c0752298ca30&fromvn=true',
            type: "GET",

            dataType: 'jsonp',
            data: {

            },
            success: function(data) {
                if (keyword != "" && keyword != null) {
                    $("#result").empty();
                }
                songlist = [];
                result = "<div class='res__list'>";

                $.each(data.docs, function() {
                    result =
                        result = result + "<div class='info'>" + "<span class='info__title'>" + this.title + "</span>, " + "<span class='info__artist'>" + this.artist + "</span>" + "<a class='add-btn' data-id=" + this.song_id + ">Add</a>" + "<a class='play-btn'>Play</a>" + "<audio preload='auto' ><source src=" + this.source['128'] + " type=\"audio/mpeg\">Your browser does not support the audio element.</audio>" + "</div>";
                    songlist.push(this);
                });

                $("#result").html(result + "</div>").fadeIn();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);
            }
        });
    });

    //POST new song
    $('#result').on("click", ".add-btn", function() {
        id = $(this).data('id');
        var song;
        for (i = 0; i < songlist.length; i++) {
            if (songlist[i].song_id == id) {
                song = songlist[i];
            }
        }

        $.ajax({
            url: '/songs',
            type: 'POST',
            //dataType: 'json',
            data: {
                "_token": $("meta[name='csrf-token']").attr('content'),
                'song': song
            },

            success: function(data) {
                //  addSong( data.id);
                // alert(data);

                if (typeof data == 'object') {
                    swal('Success!', 'This song was added to playlist.', 'success');
                } else {
                    swal('', data, 'warning');
                }
                $('#txt_search').val('');
                $("#result").empty();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);
            }
        });
    });

    // Try new song
    $('#result').on("click", ".play-btn", function() {
        // console.log($(this).next()[0].play())
        //pause all songs

        // var sounds = document.getElementsByTagName('audio');
        // for(i=0; i < sounds.length; i++) {
        //     sounds[i].pause();
        // }

        var sounds = $('#result').find('audio');
        sounds.each(function(i, el) {
            $(el).trigger('pause');
            // console.log(el)
        })

        if ($(this).text() == 'Playing') {
            $('.play-btn').text('Play');
            // $(this).text('Pause');
        } else {

            if ($('#player_play').hasClass('fa-pause')) {
                $('#player_play').click();
            }

            $(this).next()[0].play();

            $('.play-btn').text('Play');
            $(this).text('Playing');
        }
        // $('audio').pause();
    });

    //Exit the search form
    // $('#result').click(function(event) {
    //   if(event.target == this) {
    //     $('#txt_search').val('');
    //     $('#result').empty();
    //   }
    // })

    $(document).mouseup(function(e) {

        var container = $(".res__list");
        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            // container.hide();
            $('#txt_search').val('');
            $('#result').empty();
        }
    });


    // DELETE  song

    $('#playlist').on('click', '.remove-btn', function(e) {
        // if (!confirm('Are you sure want to remove this song?')) {
        //     e.preventDefault();
        //     return;
        // }
        var id = $(this).data('id');
        // user_id = {{(Auth::check()) ? (Auth::id()) : (0) }};

        swal({
            title: '',
            text: "Are you sure want to remove this song?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK'
        }).then(function() {
            $.ajax({
            url: '/songs/' + id,
            type: 'DELETE',
            data: {
                "_token": $("meta[name='csrf-token']").attr('content')
                    // "song_id": song_id,
                    // "user_id": user_id
            },
            success: function(data) {
                // if(data != "success"){
                //     alert(data);
                // }else{
                //     location.reload();
                // }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);
            }
        })
        })
        
    });

    //Vote
    $('#playlist').on('click', '.up', function() {
        var self = $(this);
        var id = $(this).data('id');
        var pos = Number($(this).closest('td').data('pos'));
        pos = pos + 1;

        $.ajax('songs/' + id, {
            data: {
                "_token": $("meta[name='csrf-token']").attr('content'),
                "position": pos
            },
            method: 'PATCH',
            success: function() {
                $.get("/votes", function(data) {
                    $("#votes").html(data);
                });
                // var el = $('#counter');
                // var cnt = Number(el.text());
                // // console.log(cnt);
                // el.text(cnt - 1);
                // self.closest('td').data('pos', pos)
                // removeItem( id );
                // moveSong(id);
                // addItem( id, isCompleted );

            }
        });
    });
    $('#playlist').on('click', '.down', function() {
        var self = $(this);
        var id = $(this).data('id');
        var pos = Number($(this).closest('td').data('pos'));
        pos = pos - 1;
        if (pos < 0) {
            pos = 0;
        }
        $.ajax('songs/' + id, {
            data: {
                "_token": $("meta[name='csrf-token']").attr('content'),
                "position": pos
            },
            method: 'PATCH',
            success: function() {
                $.get("/votes", function(data) {
                    $("#votes").html(data);
                });
            }
        });
    });

});