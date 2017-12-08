<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSoldEventTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_event_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')->references('id')->on('user_businesses');
            $table->integer('business_event_id')->unsigned();
            $table->foreign('business_event_id')->references('id')->on('business_events')->onDelete('cascade');
            $table->integer('event_seating_plan_id')->unsigned();
            $table->foreign('event_seating_plan_id')->references('id')->on('event_seating_plans');
            $table->string('transaction_id')->nullable();
            $table->double('per_ticket_price', 15, 2)->nullable();
            $table->double('user_per_ticket_price', 15, 2)->nullable();
            $table->integer('total_tickets_buyed')->nullable();
            $table->double('total_tickets_price', 15, 2)->nullable();
            $table->double('user_total_tickets_price', 15, 2)->nullable();
            
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
        Schema::drop('sold_event_tickets');
    }
}
