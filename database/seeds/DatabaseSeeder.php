<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config')->insert([
            'start_time' => str_random(10),
            'duration' => str_random(10),
            'option' => str_random(10),
        ]);
    }
}
