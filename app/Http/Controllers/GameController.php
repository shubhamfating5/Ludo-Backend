<?php

namespace App\Http\Controllers;

use App\Events\GameTicked;
use App\Events\TurnChanged;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GameController extends Controller
{
    public function create(Request $request)
    {
        $game = Game::create([
            'code' => Str::upper(Str::random(6)),
            'total_time' => 300,
            'time_left' => 300,
            'max_players' => $request->input('max_players', 2)
        ]);

        return response()->json($game);
    }

    public function setupPlayers(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'players' => 'required|array|min:2|max:4',
            'players.*.name' => 'required|string'
        ]);

        $game = Game::findOrFail($request->game_id);

        foreach ($request->players as $index => $playerData) {
            Player::create([
                'game_id' => $game->id,
                'name' => $playerData['name'],
                'turn_time' => 15,
                'is_active' => $index === 0,
            ]);
        }

        $firstPlayer = $game->players()->first();
        $game->update(['current_turn_player_id' => $firstPlayer->id]);

        return response()->json(['message' => 'Players set up successfully']);
    }

    public function startTurn(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'remaining_turn_time' => 'nullable|numeric|min:0|max:15'
        ]);

        $game = Game::with('players')->findOrFail($request->game_id);
        $players = $game->players->sortBy('id')->values();

        if ($players->isEmpty()) {
            Log::warning("No players found for game_id = {$game->id}");
            return response()->json(['message' => 'No players in the game.'], 400);
        }

        $consumedTime = $request->input('remaining_turn_time', 15);
        if (is_numeric($consumedTime)) {
            $consumedTime = 15 - min($consumedTime, 15);
        } else {
            $consumedTime = 15;
        }

        $currentIndex = $players->search(fn($p) => $p->id === $game->current_turn_player_id);
        $nextIndex = is_numeric($currentIndex) ? $currentIndex + 1 : 0;
        if ($nextIndex >= $players->count()) {
            $nextIndex = 0;
        }

        $nextPlayer = $players[$nextIndex];
        $newTimeLeft = max($game->time_left - $consumedTime, 0);

        $game->update([
            'current_turn_player_id' => $nextPlayer->id,
            'time_left' => $newTimeLeft,
        ]);

        broadcast(new TurnChanged($game->id, $nextPlayer, 15, $newTimeLeft))->toOthers();
        broadcast(new GameTicked($game->id, $newTimeLeft))->toOthers();

        return response()->json([
            'message' => 'Turn started.',
            'player' => $nextPlayer,
            'new_time_left' => $newTimeLeft
        ]);
    }

    public function getGameState($code)
    {
        $game = Game::with('players')->where('code', $code)->firstOrFail();
        return response()->json($game);
    }
}