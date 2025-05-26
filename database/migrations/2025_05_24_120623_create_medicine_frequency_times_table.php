<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicine_frequency_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('frequency_id')->constrained('medicine_frequencies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->time('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_schedule_times');
    }
};
