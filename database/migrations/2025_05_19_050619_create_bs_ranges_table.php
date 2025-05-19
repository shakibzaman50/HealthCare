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
        Schema::create('bs_ranges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('sugar_unit_id')->constrained('sugar_units')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('measurement_type_id')->constrained('bs_measurement_types')->onDelete('cascade')->onUpdate('cascade');
            $table->string('category');
            $table->decimal('min_value', 8, 2);
            $table->decimal('max_value', 8, 2);
            $table->timestamps();

            // Add index 
            $table->index(['sugar_unit_id', 'measurement_type_id', 'category']);
            $table->index(['min_value', 'max_value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bs_ranges');
    }
};