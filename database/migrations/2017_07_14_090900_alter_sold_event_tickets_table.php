<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSoldEventTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sold_event_tickets', function ($table) {
            $table->dropColumn('transaction_id');
            $table->integer('event_transaction_id')->after('event_seating_plan_id')->unsigned();
            $table->foreign('event_transaction_id')->references('id')->on('event_transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sold_event_tickets', function($table) {
            $table->dropForeign(['event_transaction_id']);
            $table->dropColumn('event_transaction_id');
            $table->string('transaction_id')->after('event_seating_plan_id')->nullable();
        });
    }
}
