<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBusinessEventSeats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_event_seats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')->references('id')->on('user_businesses');
            $table->integer('business_event_id')->unsigned();
            $table->foreign('business_event_id')->references('id')->on('business_events')->onDelete('cascade');
            $table->integer('event_seating_plan_id')->unsigned();
            $table->foreign('event_seating_plan_id')->references('id')->on('event_seating_plans');
            $table->string('seating_plan_alias')->nullable();
            $table->integer('total_seat_available')->nullable();
            $table->double('per_ticket_price', 15, 2)->nullable();
            $table->integer('seat_buyed')->nullable();
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
        Schema::drop('business_event_seats');
    }
}
