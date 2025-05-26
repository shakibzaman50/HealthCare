<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Rename dob to birth_year
        Schema::table('profiles', function (Blueprint $table) {
            $table->renameColumn('dob', 'birth_year');
        });

        // 2. Add temporary column to hold the extracted year
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('birth_year_temp', 4)->nullable()->after('birth_year');
        });

        // 3. Extract the year part from the old DATE column and store in temp column
        DB::statement('UPDATE profiles SET birth_year_temp = YEAR(birth_year) WHERE birth_year IS NOT NULL');

        // 4. Drop the original birth_year column (DATE type)
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('birth_year');
        });

        // 5. Rename temp column to birth_year
        Schema::table('profiles', function (Blueprint $table) {
            $table->renameColumn('birth_year_temp', 'birth_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Add dob as date
        Schema::table('profiles', function (Blueprint $table) {
            $table->date('dob')->nullable()->after('birth_year');
        });
        // 2. Convert year to a date format (defaulting to Jan 1st)
        DB::statement("UPDATE profiles SET dob = STR_TO_DATE(CONCAT(birth_year, '-01-01'), '%Y-%m-%d') WHERE birth_year IS NOT NULL");
        // 3. Drop the year column
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('birth_year');
        });
        // 4. Rename dob back to original if needed (optional)
        Schema::table('profiles', function (Blueprint $table) {
            $table->renameColumn('birth_year', 'dob');
        });
    }
};