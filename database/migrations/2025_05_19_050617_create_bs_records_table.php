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
        Schema::create('bs_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('profiles');
            $table->foreignId('sugar_schedule_id')->constrained('sugar_schedules')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('sugar_unit_id')->constrained('sugar_units')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('value', 8, 2);
            $table->string('status');
            $table->dateTime('measured_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bs_records');
    }
};