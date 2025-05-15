<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhysicalConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('physical_conditions');
    }
}
