<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
     protected $fillable = ['game_id', 'name', 'turn_order', 'turn_time', 'is_active'];

    public function game() {
        return $this->belongsTo(Game::class);
    }
}
