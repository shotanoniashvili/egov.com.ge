<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomCriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_criteria', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('criteria_id');
            $table->string('title');
            $table->integer('point');
            $table->integer('order')->default(0);

            $table->foreign('criteria_id')->references('id')->on('criterias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_criteria');
    }
}
