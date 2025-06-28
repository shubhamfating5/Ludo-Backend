<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PlayerJoined implements ShouldBroadcast
{
    use SerializesModels;

    public $gameId;
    public $players;

    public function __construct($gameId)
    {
        $this->gameId = $gameId;
        $this->players = \App\Models\Player::where('game_id', $gameId)->get();
    }

    public function broadcastOn()
    {
        return new Channel('game.' . $this->gameId);
    }

    public function broadcastAs()
    {
        return 'PlayerJoined';
    }
}
