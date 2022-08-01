<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssignmentAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('assignment_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mark')->nullable();
            $table->string('file_path')->nullable();
            $table->string('marked_answer')->nullable();
            $table->timestamps();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('assignment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('assignment_answers');
    }
}
