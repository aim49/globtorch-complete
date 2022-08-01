<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('city')->nullable();
            $table->string('country');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('school_id',30)->unique();
            $table->string('password');
            $table->string('user_type');
            $table->boolean('isEnabled')->default(1);
            $table->string('referrer')->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->string('feedback', 500)->nullable();
            $table->string('description', 10000)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedInteger('institution_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
