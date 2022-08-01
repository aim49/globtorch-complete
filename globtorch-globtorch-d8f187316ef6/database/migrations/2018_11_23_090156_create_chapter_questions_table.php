<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChapterQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question', 2000);
            $table->string('answer_a', 1000);
            $table->string('answer_b', 1000);
            $table->string('answer_c', 1000);
            $table->string('answer_d', 1000);
            $table->string('answer', 1000);
            $table->timestamps();
            $table->unsignedInteger('chapter_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chapter_questions');
    }
}
