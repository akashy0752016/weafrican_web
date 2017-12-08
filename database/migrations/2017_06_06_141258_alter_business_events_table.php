<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBusinessEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_events', function ($table) {
            $table->integer('total_seats')->after('longitude')->nullable();
            $table->string('event_log_id')->after('slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_events', function($table) {
            $table->dropColumn('total_seats');
            $table->dropColumn('event_log_id');
        });
    }
}
