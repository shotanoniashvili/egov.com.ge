<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->text('short_description')->nullable();
            $table->unsignedBigInteger('municipality_id')->nullable();
            $table->longText('picture')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->boolean('is_archive')->default(false);
            $table->boolean('is_active_for_experts')->default(false);
            $table->boolean('is_active_for_web')->default(false);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('project_categories');
            $table->foreign('municipality_id')->references('id')->on('municipalities');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
