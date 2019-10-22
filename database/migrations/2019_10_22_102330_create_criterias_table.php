<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->unsignedBigInteger('rate_id');
            $table->unsignedBigInteger('parent_criteria_id')->nullable();
            $table->unsignedInteger('percent_in_total')->nullable();
            $table->unsignedInteger('max_point')->nullable();
            $table->unsignedInteger('yes_point')->nullable();
            $table->unsignedInteger('no_point')->nullable();

            $table->foreign('rate_id')->references('id')->on('rates');
            $table->foreign('parent_criteria_id')->references('id')->on('criterias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criterias');
    }
}
