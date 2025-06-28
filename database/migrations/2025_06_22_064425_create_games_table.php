<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
              $table->string('code')->unique();
    $table->integer('total_time')->default(300); // in seconds (5 mins default)
    $table->integer('time_left')->default(300);
    $table->unsignedBigInteger('current_turn_player_id')->nullable();
    $table->integer('max_players')->default(2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
