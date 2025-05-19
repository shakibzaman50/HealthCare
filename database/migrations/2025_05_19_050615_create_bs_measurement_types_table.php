<?php

use App\Enums\StatusEnums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bs_measurement_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string("status")->default(StatusEnums::ACTIVE->value);
            $table->timestamps();

            // Add index for faster lookup
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bs_measurement_types');
    }
};