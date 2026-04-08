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
        Schema::create('membership_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. 2026-01
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('fee_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_periods');
    }
};
