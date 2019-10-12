<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFulltextIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE municipalities ADD FULLTEXT fulltext_index (name)');
        DB::statement('ALTER TABLE news ADD FULLTEXT fulltext_index (title, content)');
        DB::statement('ALTER TABLE projects ADD FULLTEXT fulltext_index (title, short_description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
