<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaynowTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('paynow_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref');
            $table->string('url');
            $table->timestamps();
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('user_id');
            $table->date('payment_date');
            $table->date('start_date');
            $table->integer('period');
            $table->unsignedInteger('enrollment_id');
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
        Schema::dropIfExists('paynow_transactions');
    }
}
