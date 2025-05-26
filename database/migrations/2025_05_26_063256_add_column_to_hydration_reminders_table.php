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
        Schema::table('hydration_reminders', function (Blueprint $table) {
            $table->boolean('status')->nullable()->comment('1:Hydrated, 0:Dehydrated')->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hydration_reminders', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
};
