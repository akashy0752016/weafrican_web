<?php

use Illuminate\Database\Seeder;

class BusinessServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_services')->delete();

        DB::table('business_services')->insert([[
        	'id' => 1,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Service 1',
        	'slug' => 'service-1',
        	'description' => 'Service 1',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 2,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Service 2',
        	'slug' => 'service-2',
        	'description' => 'Service 2',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 3,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Service 3',
        	'slug' => 'service-3',
        	'description' => 'Service 3',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 4,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Service 4',
        	'slug' => 'service-4',
        	'description' => 'Service 4',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 5,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Service 5',
        	'slug' => 'service-5',
        	'description' => 'Service 5',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 6,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Service 6',
        	'slug' => 'service-6',
        	'description' => 'Service 6',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 7,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Service 7',
        	'slug' => 'service-7',
        	'description' => 'Service 7',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 8,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Service 8',
        	'slug' => 'service-8',
        	'description' => 'Service 8',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 9,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Service 9',
        	'slug' => 'service-9',
        	'description' => 'Service 9',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 10,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Service 10',
        	'slug' => 'service-10',
        	'description' => 'Service 10',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 11,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Service 11',
        	'slug' => 'service-11',
        	'description' => 'Service 11',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
    }
}
