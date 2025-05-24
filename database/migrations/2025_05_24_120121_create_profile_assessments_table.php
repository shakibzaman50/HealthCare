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
        Schema::create('profile_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->boolean('live_active_lifestyle')->default(1);
            $table->boolean('insulin_resistance')->default(0);
            $table->boolean('hypertension')->default(0);
            $table->unsignedBigInteger('activity_level_id')->nullable();
            $table->integer('hydration_goal')->default(0)->nullable();
            $table->unsignedBigInteger('physical_condition_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_assessments');
    }
};
