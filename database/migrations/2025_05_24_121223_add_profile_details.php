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
        Schema::table('profiles', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('bmi');
            $table->unsignedBigInteger('weight_unit')->nullable()->after('weight');
            $table->unsignedBigInteger('height_unit')->nullable()->after('height');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['gender', 'weight_unit', 'height_unit']);
        });
    }
};
