<?php

namespace App\Providers;

use Event;
use App\Song;
use App\Events\SongCreated;
use App\Events\SongUpdated;
use App\Events\SongDeleted;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Song::created(function ($song) {
            Event::fire(new SongCreated($song));
        });

        Song::updated(function ($song) {
            Event::fire(new SongUpdated($song));
        });

        Song::deleted(function ($song) {
            Event::fire(new SongDeleted($song));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
