<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use App\Events\GameTicked;

class TickGames extends Command
{
    protected $signature = 'game:tick';
    protected $description = 'Tick down total game timers every second';

    public function handle()
    {
        $games = Game::where('time_left', '>', 0)->get();

        foreach ($games as $game) {
            $game->decrement('time_left', 1);
            broadcast(new GameTicked($game->id, $game->time_left))->toOthers();
        }

        return 0;
    }
}