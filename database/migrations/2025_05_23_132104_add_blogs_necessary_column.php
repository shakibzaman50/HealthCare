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
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('status')->after('content')->default('draft');
            $table->string('visibility')->after('status')->default('public');
            $table->string('meta_title')->after('visibility')->nullable();
            $table->string('meta_description')->after('meta_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['status', 'visibility', 'meta_title', 'meta_description']);
        });
    }
};
