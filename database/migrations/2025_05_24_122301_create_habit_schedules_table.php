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
        Schema::create('habit_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('habit_task_id');
            $table->boolean('type')->comment('1:build, 0:quit');
            $table->time('duration')->nullable();
            $table->string('color', 50)->nullable();
            $table->string('description', 255)->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_repeat')->default(false)->comment('1:repeat');
            $table->boolean('till_turn_off')->default(false)->comment('1:on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_schedules');
    }
};
