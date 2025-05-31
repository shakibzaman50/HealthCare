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
        Schema::create('habit_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('habit_list_id');
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->string('name',50);
            $table->boolean('is_active')->default(1);
            $table->string('icon', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_tasks');
    }
};
