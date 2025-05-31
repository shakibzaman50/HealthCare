<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->boolean('allow_all_notification')->default(true);
            $table->boolean('notification_snozing')->default(true);
            $table->boolean('notification_dot_on_app')->default(true);
            $table->boolean('reminder_notifications')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};