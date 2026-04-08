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
        Schema::create('session_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('sessions')->cascadeOnDelete();
            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();
            $table->timestamp('checked_in_at');

            // fairness tracker per sesi
            $table->unsignedInteger('played_count')->default(0);
            $table->timestamp('last_played_at')->nullable();

            // pembayaran per datang (opsional)
            $table->unsignedInteger('per_visit_fee_amount')->nullable();
            $table->string('per_visit_payment_status')->default('unpaid'); // unpaid/paid/waived
            $table->timestamps();

            $table->unique(['session_id', 'player_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_attendances');
    }
};
