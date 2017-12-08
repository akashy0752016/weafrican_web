<?php

use Illuminate\Database\Seeder;

class SubscriptionPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('subscription_plans')->delete();
        
        DB::table('subscription_plans')->insert([
           ['id' => 1, 'title' => 'Elite Sponsor', 'slug' => 'sponser-plan-1', 'coverage' => 'Country', 'validity_period' => 30,'price' => 100,'keywords_limit' => '0', 'is_blocked' => 0, 'type' => 'sponsor', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

           ['id' => 2, 'title' => 'Professional Sponsor ', 'slug' => 'sponser-plan-1', 'coverage' => 'State', 'validity_period' => 30,'price' => 10,'keywords_limit' => '0', 'is_blocked' => 0, 'type' => 'sponsor', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

           ['id' => 3, 'title' => 'ELITE BUSINESS', 'slug' => 'business-plan-elite-1', 'coverage' => 'Country','validity_period' => 30, 'price' => 10, 'keywords_limit' => '10','is_blocked' => 0, 'type' => 'business', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           
           ['id' => 4, 'title' => 'PROFESSIONAL BUSINESS', 'slug' => 'business-plan-professional-2', 'coverage' => 'State', 'price' => 30,'validity_period' => 30,'keywords_limit' => '20', 'is_blocked' => 0, 'type' => 'business', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           
           ['id' => 5, 'title' => 'STANDARD BUSINESS', 'slug' => 'business-plan-standard-3', 'coverage' => 'City','validity_period' => 30, 'price' => 50,'keywords_limit' => '30', 'is_blocked' => 0, 'type' => 'business', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

           ['id' => 6, 'title' => 'TOP BUSINESS SEARCH', 'slug' => 'business-plan-seatch-3', 'coverage' => 'Country','validity_period' => 30, 'price' => 40,'keywords_limit' => '30', 'is_blocked' => 0, 'type' => 'business', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

           ['id' => 7, 'title' => 'ELITE EVENTS ADS', 'slug' => 'event-plan-elite-1', 'coverage' => 'Country','validity_period' => 30, 'price' => 40, 'keywords_limit' => '10','is_blocked' => 0, 'type' => 'event', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           
           ['id' => 8, 'title' => 'PROFESSIONAL EVENTS ADS', 'slug' => 'event-plan-professional-2', 'coverage' => 'State', 'price' => 100,'validity_period' => 30,'keywords_limit' => '20', 'is_blocked' => 0, 'type' => 'event', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           
           ['id' => 9, 'title' => 'STANDARD EVENTS ADS', 'slug' => 'event-plan-standard-3', 'coverage' => 'City','validity_period' => 30, 'price' => 200,'keywords_limit' => '30', 'is_blocked' => 0, 'type' => 'event', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

           ['id' => 10, 'title' => 'Top Event Listing', 'slug' => 'event-plan-seatch-3', 'coverage' => 'Country','validity_period' => 30, 'price' => 100,'keywords_limit' => '30', 'is_blocked' => 0, 'type' => 'event', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

           ['id' => 11, 'title' => 'Premium', 'slug' => 'premimum-plan-1', 'coverage' => 'Country','validity_period' => 30, 'price' => 250 ,'keywords_limit' => '', 'is_blocked' => 0, 'type' => 'premium', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}
