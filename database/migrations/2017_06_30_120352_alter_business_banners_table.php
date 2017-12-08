<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBusinessBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_banners', function ($table) {
            $table->integer('business_category_id')->after('image')->nullable();
            $table->integer('business_subcategory_id')->after('business_category_id')->nullable();
            $table->boolean('is_selected')->after('is_blocked')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_banners', function($table) {
            $table->dropColumn('business_category_id');
            $table->dropColumn('business_subcategory_id');
            $table->dropColumn('is_selected');
        });
    }
}
