<?php

use App\Enums\ScheduleEnums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reminder_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reminder_id')->nullable()->constrained('medicine_reminders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('schedule_type')->default(ScheduleEnums::EVERY->value);
            $table->integer('how_many_times')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_schedules');
    }
};
