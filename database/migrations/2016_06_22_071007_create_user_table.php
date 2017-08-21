<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
          $table->increments('id');
          $table->string('role')->default ('user');
          $table->string('status')->default('unblock');
          $table->string('name');
          $table->string('email')->unique();
          $table->string('password', 60);
          $table->string('first_name');
          $table->string('last_name');
          $table->string('address');
          $table->timestamp('last_login');
          $table->integer('vote_counter');
          $table->rememberToken();
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
        Schema::drop('users');
    }

}
