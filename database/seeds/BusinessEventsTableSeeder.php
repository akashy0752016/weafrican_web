<?php

use Illuminate\Database\Seeder;

class BusinessEventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_events')->delete();

        DB::table('business_events')->insert([[
            'id' => 1,
            'user_id' => 5,
            'business_id' => 1,
            'event_category_id' => 1,
            'name' => 'Test',
            'keywords' => 'Test',
            'slug' => 'test-1',
            'description' => 'Test',
            'organizer_name' => 'Divya',
            'start_date_time' => '2017-06-12 19:12:00',
            'end_date_time' => '2017-06-12 19:12:00',
            'banner' => Null,
            'address' => 'New Delhi, Delhi 110075, India',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'country' => 'Delhi',
            'pin_code' => '110058',
            'latitude' => '28.585293',
            'longitude' => '77.070404',
            'total_seats' => 500,
            'is_blocked' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'id' => 2,
            'user_id' => 5,
            'business_id' => 1,
            'event_category_id' => 1,
            'name' => 'Test2',
            'keywords' => 'Test2',
            'slug' => 'test-2',
            'description' => 'Test2',
            'organizer_name' => 'Divya',
            'start_date_time' => '2017-06-12 19:12:00',
            'end_date_time' => '2017-06-12 19:12:00',
            'banner' => Null,
            'address' => 'New Delhi, Delhi 110075, India',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'country' => 'Delhi',
            'pin_code' => '110058',
            'latitude' => '28.585293',
            'longitude' => '77.070404',
            'total_seats' => 500,
            'is_blocked' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],]);
    }
}
