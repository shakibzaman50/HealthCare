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
        Schema::create('habit_frequencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('habit_schedule_id');
            $table->enum('day',['EVERY','SAT','SUN','MON','TUE','WED','THU','FRI']);
            $table->tinyInteger('how_many_times');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_frequencies');
    }
};
