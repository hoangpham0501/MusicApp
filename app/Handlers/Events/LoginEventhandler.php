<?php

namespace App\Handlers\Events;

use App\Events;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Carbon\Carbon;

class LoginEventhandler
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Events  $event
     * @return void
     */
    public function handle(User $user)
    {
        $cnt = $user->vote_counter;
        if($user->last_login != Carbon::today()) {
            $user->vote_counter = 5;
        }

        $user->last_login = Carbon::today();
        $user->save();
    }
}
