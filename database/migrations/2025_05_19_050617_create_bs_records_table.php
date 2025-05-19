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
            $table->foreignId('measurement_type_id')->constrained('bs_measurement_types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('sugar_unit_id')->constrained('sugar_units')->onDelete('restrict')->onUpdate('cascade');
            $table->decimal('value', 8, 2);
            $table->dateTime('measurement_at');
            $table->timestamps();

            $table->index(['measurement_type_id', 'sugar_unit_id']);
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