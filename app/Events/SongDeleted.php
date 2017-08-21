<?php

namespace App\Events;

use App\Song;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SongDeleted extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Song $song)
    {
        $this->id = $song->id;
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
