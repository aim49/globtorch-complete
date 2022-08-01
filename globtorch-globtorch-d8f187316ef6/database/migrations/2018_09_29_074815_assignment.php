<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Assignment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::create('assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('due_date');
            $table->string('file_path');
            $table->timestamps();
            $table->unsignedInteger('subject_id');
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
         Schema::dropIfExists('assignments');
    }
}
