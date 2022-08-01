<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChapterResutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('score');
            $table->integer('total');
            $table->integer('percentage');
            $table->timestamps();
            $table->unsignedInteger('chapter_id');
            $table->unsignedInteger('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chapter_results');
    }
}
