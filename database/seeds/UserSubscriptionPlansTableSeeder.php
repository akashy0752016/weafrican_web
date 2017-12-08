<?php

use Illuminate\Database\Seeder;

class UserSubscriptionPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_subscription_plans')->delete();
        
        DB::table('user_subscription_plans')->insert([[
        	'id' => 1,
        	'user_id' => 5,
        	'subscription_plan_id' => 1,
        	'subscription_date' => date('Y-m-d H:i:s'),
        	'expired_date' => date('Y-m-d H:i:s'),
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
        	'id' => 2,
        	'user_id' => 6,
        	'subscription_plan_id' => 2,
        	'subscription_date' => date('Y-m-d H:i:s'),
        	'expired_date' => date('Y-m-d H:i:s'),
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
        	'id' => 3,
        	'user_id' => 5,
        	'subscription_plan_id' => 2,
        	'subscription_date' => date('Y-m-d H:i:s'),
        	'expired_date' => date('Y-m-d H:i:s'),
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
    }
}
