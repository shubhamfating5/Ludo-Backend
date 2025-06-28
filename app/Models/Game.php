<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

     protected $fillable = ['code', 'total_time', 'time_left', 'current_turn_player_id', 'max_players'];

    public function players() {
        return $this->hasMany(Player::class);
    }

     public function currentPlayer()
    {
        return $this->belongsTo(Player::class, 'current_turn_player_id');
    }

    public function activePlayer()
{
    return $this->belongsTo(Player::class, 'current_turn_player_id');
}
    
}
