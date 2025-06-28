<?php

namespace App\Events;

use App\Models\Player;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TurnChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gameId, $player, $turnTime, $totalTimeLeft;

    public function __construct($gameId, Player $player, $turnTime = 15, $totalTimeLeft)
    {
        $this->gameId = $gameId;
        $this->player = $player;
        $this->turnTime = $turnTime;
        $this->totalTimeLeft = $totalTimeLeft;
    }

    public function broadcastOn()
    {
        return new Channel('game.' . $this->gameId);
    }

    public function broadcastAs()
    {
        return 'TurnChanged';
    }

    public function broadcastWith()
    {
        return [
            'player' => $this->player,
            'turnTime' => $this->turnTime,
            'totalTimeLeft' => $this->totalTimeLeft,
        ];
    }
}