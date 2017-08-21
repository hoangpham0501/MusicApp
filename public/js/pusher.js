(function($, pusher, addSong, moveSong ) {

	var songActionChannel = pusher.subscribe( 'songAction' );

	songActionChannel.bind("App\\Events\\SongCreated", function( data ) {
	    addSong(data.id);
	});

	songActionChannel.bind("App\\Events\\SongUpdated", function( data ) {
	    moveSong();
	});

	songActionChannel.bind( "App\\Events\\SongDeleted", function( data ) {
			removeSong(data.id);
	});

})(jQuery, pusher, addSong, moveSong, removeSong);
