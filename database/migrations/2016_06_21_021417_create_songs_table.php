<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('song_id');
            $table->string('title');
            $table->string('artist');
            $table->string('genre');
            $table->string('username');
            $table->string('bitrate');
            $table->integer('duration');
            $table->boolean('have_rbt');
            $table->integer('download_status');
            $table->string('copyright');
            $table->string('artist_ids');
            $table->string('link');
            $table->integer('total_play');
            $table->string('link_download');
            $table->string('source');
            $table->string('lyrics_file');
            $table->integer('add_by_user');
            $table->integer('position')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('songs');
    }
}
