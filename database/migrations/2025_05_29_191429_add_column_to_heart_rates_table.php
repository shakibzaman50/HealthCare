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
        Schema::table('heart_rates', function (Blueprint $table) {
            $table->enum('hrv_status', ['Low', 'Below Average', 'Average', 'Good', 'Excellent'])->nullable()->after('hrv');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('heart_rates', function (Blueprint $table) {
            $table->dropColumn(['hrv_status']);
        });
    }
};
