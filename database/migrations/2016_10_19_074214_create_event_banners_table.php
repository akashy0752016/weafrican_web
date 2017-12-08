<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_banners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')->references('id')->on('user_businesses');
            $table->integer('user_subscription_plan_id')->unsigned();
            $table->foreign('user_subscription_plan_id')->references('id')->on('user_subscription_plans');
            $table->integer('event_category_id')->unsigned()->nullable();
            $table->foreign('event_category_id')->references('id')->on('event_categories');
            $table->string('image')->nullable();
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->decimal('latitude', 9, 6)->nullable();
            $table->float('longitude', 9 , 6)->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->boolean('is_selected')->default(false);
            $table->integer('business_event_id')->unsigned()->nullable();
            $table->foreign('business_event_id')->references('id')->on('business_events');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_banners');
    }
}
