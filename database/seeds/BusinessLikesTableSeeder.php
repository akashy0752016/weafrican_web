<?php

use Illuminate\Database\Seeder;

class BusinessLikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_likes')->delete();

        DB::table('business_likes')->insert([[
        	'id' => 1,
        	'user_id' => 1,
        	'business_id' => 1,
        	'is_like' => 0,
        	'is_dislike' => 1,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 2,
        	'user_id' => 2,
        	'business_id' => 1,
        	'is_like' => 0,
        	'is_dislike' => 1,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 3,
        	'user_id' => 3,
        	'business_id' => 1,
        	'is_like' => 0,
        	'is_dislike' => 1,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 4,
        	'user_id' => 4,
        	'business_id' => 1,
        	'is_like' => 0,
        	'is_dislike' => 1,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 5,
        	'user_id' => 6,
        	'business_id' => 1,
        	'is_like' => 0,
        	'is_dislike' => 1,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 6,
        	'user_id' => 7,
        	'business_id' => 1,
        	'is_like' => 1,
        	'is_dislike' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 7,
        	'user_id' => 8,
        	'business_id' => 1,
        	'is_like' => 0,
        	'is_dislike' => 1,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);	
    }
}
