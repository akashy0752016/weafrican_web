<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_subscription_plans', function ($table) {
            $table->string('first_name')->after('subscription_plan_id')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->string('email')->after('last_name')->nullable();
            $table->string('amount')->after('email')->nullable();
            $table->string('currency')->after('amount')->nullable();
            $table->string('user_amount')->after('currency')->nullable();
            $table->string('user_currency')->after('user_amount')->nullable();
            $table->string('reference_id')->after('currency')->nullable();
            $table->string('authorization_code')->after('reference_id')->nullable();
            $table->string('transaction_date')->after('authorization_code')->nullable();
            $table->string('transaction_message')->after('transaction_date')->nullable();
            $table->string('is_premium')->after('transaction_message')->default(false);
            $table->string('is_auto_renew')->after('is_premium')->default(false);
            $table->string('status')->after('transaction_date')->nullable();
            $table->string('ip_address')->after('status')->nullable();
            $table->boolean('is_expired')->after('expired_date')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_subscription_plans', function($table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('email');
            $table->dropColumn('amount');
            $table->dropColumn('currency');
            $table->dropColumn('user_amount');
            $table->dropColumn('user_currency');
            $table->dropColumn('reference_id');
            $table->dropColumn('transaction_date');
            $table->dropColumn('status');
            $table->dropColumn('ip_address');
            $table->dropColumn('is_expired');
        });
    }
}
