<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEventTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_tickets', function ($table) {
            $table->integer('event_transaction_id')->after('event_id')->unsigned();
            $table->foreign('event_transaction_id')->references('id')->on('event_transactions')->onDelete('cascade');
            $table->string('primary_booking_id')->after('event_transaction_id');
            $table->string('sub_booking_id')->after('primary_booking_id');
            $table->dropColumn('booking_id');
            $table->dropColumn('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_tickets', function($table) {
            $table->dropForeign(['event_transaction_id']);
            $table->dropColumn('event_transaction_id');
            $table->dropColumn('sub_booking_id');
            $table->dropColumn('primary_booking_id');
            $table->string('booking_id')->after('id');
            $table->string('transaction_id')->after('event_id');
        });
    }
}
