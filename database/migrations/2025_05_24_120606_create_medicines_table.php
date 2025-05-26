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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('profiles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('medicine_type_id')->constrained('medicine_types');
            $table->bigInteger('medicine_unit_id')->constrained('medicine_units');
            $table->string('name');
            $table->bigInteger('strength');
            $table->boolean('is_active')->default(value: config('basic.status.active'));
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
