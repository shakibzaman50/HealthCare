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
        Schema::table('blood_oxygens', function (Blueprint $table) {
            $table->boolean('status')->nullable()->comment('1:Saturated, 0:Desaturated')->after('oxygen_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blood_oxygens', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
};
