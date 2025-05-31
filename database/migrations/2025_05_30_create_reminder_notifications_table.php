<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reminder_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->boolean('heart_beat')->default(true);
            $table->boolean('blood_presure')->default(true);
            $table->boolean('blood_sugar')->default(true);
            $table->boolean('water_intake')->default(true);
            $table->boolean('habit_tracker')->default(true);
            $table->boolean('medication')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reminder_notifications');
    }
};
