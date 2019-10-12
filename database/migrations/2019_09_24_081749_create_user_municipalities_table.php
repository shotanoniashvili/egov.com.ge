<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMunicipalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_municipalities', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('municipality_id');

            $table->primary(['user_id', 'municipality_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('municipality_id')->references('id')->on('municipalities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_municipalities');
    }
}
