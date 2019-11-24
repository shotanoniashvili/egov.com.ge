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
            $table->unsignedBigInteger('rate_id');
            $table->text('name');
            $table->unsignedBigInteger('parent_criteria_id')->nullable();
            $table->integer('yes_point')->nullable();
            $table->integer('no_point')->nullable();
            $table->boolean('is_percentable')->default(false);

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
