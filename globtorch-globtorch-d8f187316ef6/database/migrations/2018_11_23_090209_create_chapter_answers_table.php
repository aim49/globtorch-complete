<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChapterAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('answer', 1000)->nullable();
            $table->boolean('isCorrect');
            $table->timestamps();
            $table->unsignedInteger('chapter_question_id');
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
        Schema::dropIfExists('chapter_answers');
    }
}
