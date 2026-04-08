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
        Schema::table('session_attendances', function (Blueprint $table) {
            $table->boolean('per_visit_fee_paid')->default(false)->after('per_visit_fee_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_attendances', function (Blueprint $table) {
            $table->dropColumn('per_visit_fee_paid');
        });
    }
};
