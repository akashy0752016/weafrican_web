<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_portfolios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')->references('id')->on('user_businesses');
            $table->string('maritial_status')->nullable();
            $table->string('occupation')->nullable();
            $table->string('acedimic_status')->nullable();
            $table->string('key_skills')->nullable();
            $table->string('experience_years')->nullable();
            $table->string('experience_months')->nullable();
            $table->string('height_feets')->nullable();
            $table->string('height_inches')->nullable();
            $table->string('hair_type')->nullable();
            $table->string('skin_color')->nullable();
            $table->string('hair_color')->nullable();
            $table->boolean('professional_training')->default(false);
            $table->string('institute_name')->nullable();
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
        Schema::drop('user_portfolios');
    }
}
