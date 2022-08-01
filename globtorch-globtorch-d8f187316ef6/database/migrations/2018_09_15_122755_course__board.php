<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CourseBoard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('course_boards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exam_months');
            $table->decimal('exam_price', 8, 2);
            $table->timestamps();
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('board_id');
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
        Schema::dropIfExists('course_boards');
    }
}
