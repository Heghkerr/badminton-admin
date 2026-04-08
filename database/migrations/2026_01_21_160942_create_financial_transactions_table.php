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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('txn_date');
            $table->string('type'); // income/expense
            $table->string('category'); // per_visit_fee, membership_fee, shuttlecock, court_rent, other
            $table->unsignedInteger('amount');
            $table->string('method')->nullable(); // cash/transfer/other
            $table->text('notes')->nullable();

            // optional links
            $table->foreignId('session_id')->nullable()->constrained('sessions')->nullOnDelete();
            $table->foreignId('player_id')->nullable()->constrained('players')->nullOnDelete();
            // NOTE: migration order means membership_periods table might not exist yet at this point.
            // We'll keep the column and add FK in a follow-up migration if needed.
            $table->unsignedBigInteger('membership_period_id')->nullable();
            $table->index('membership_period_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
