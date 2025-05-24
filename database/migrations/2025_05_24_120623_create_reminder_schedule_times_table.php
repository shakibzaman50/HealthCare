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
        Schema::create('reminder_schedule_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('reminder_schedules')->cascadeOnDelete()->cascadeOnUpdate();
            $table->time('time');
            $table->string('label')->nullable();
            $table->boolean('is_active')->default(true);
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
