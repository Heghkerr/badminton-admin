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
        Schema::create('match_players', function (Blueprint $table) {
            $table->id();
            // NOTE: migration order means matches table might not exist yet at this point.
            // We'll keep the column and add FK in a follow-up migration if needed.
            $table->unsignedBigInteger('match_id');
            $table->index('match_id');
            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();
            $table->unsignedTinyInteger('team_no'); // 1/2
            $table->unsignedTinyInteger('position_no')->nullable(); // optional 1/2 in team
            $table->timestamps();

            $table->unique(['match_id', 'player_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_players');
    }
};
