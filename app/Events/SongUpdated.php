<?php

namespace App\Events;

use App\Song;
use Auth;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SongUpdated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $id;
    public $position;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Song $song)
    {
        $user = Auth::user();
        $user->decrement('vote_counter');
        $this->id = $song->id;

        $this->position = $song->position;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['songAction'];
    }
}
