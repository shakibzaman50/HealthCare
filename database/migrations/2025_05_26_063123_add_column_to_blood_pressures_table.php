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
        Schema::table('blood_pressures', function (Blueprint $table) {
            $table->enum('status', ['Low Pressure','Normal','Elevated','High BP (stage-1)','High BP (stage-2)',' Hypertensive Crisis'])->nullable()->after('diastolic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blood_pressures', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
};
