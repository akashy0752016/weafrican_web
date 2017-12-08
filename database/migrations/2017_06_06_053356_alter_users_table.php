<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->foreign('security_question_id')->references('id')->on('security_questions');
            $table->integer('mobile_verified')->after('is_verified')->default(0);
            $table->string('gender')->after('last_name')->nullable();
            $table->string('ip')->after('remember_token')->nullable();
            $table->string('mobile_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->unsignedBigInteger('mobile_number')->nullable()->change();
            $table->dropForeign(['security_question_id']);
            $table->dropColumn('mobile_verified');
            $table->dropColumn('gender');
            $table->dropColumn('ip');
        });
    }
}
