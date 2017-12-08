<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('business_event_id')->unsigned();
            $table->foreign('business_event_id')->references('id')->on('business_events');
            $table->string('total_seats_buyed');
            $table->string('amount');
            $table->string('currency');
            $table->string('user_amount');
            $table->string('user_currency');
            $table->string('reference_id');
            $table->string('transaction_date')->nullable();
            $table->string('status')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_transactions');
    }
}
