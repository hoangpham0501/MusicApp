<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockedSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocked_songs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('link_mp3')->nullable()->unique();
            $table->string('title')->nullable();
            $table->string('word')->nullable();
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
        Schema::drop('blocked_songs');
    }
}
