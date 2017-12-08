<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHomePageBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_page_banners', function ($table) {
            $table->integer('is_selected')->after('is_blocked')->default(0);
            $table->integer('business_event_id')->after('is_selected')->unsigned()->nullable();
            $table->foreign('business_event_id')->references('id')->on('business_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_page_banners', function($table) {
            $table->dropColumn('is_selected');
            $table->dropForeign(['business_event_id']);
            $table->dropColumn('business_event_id');
        });
    }
}
