<?php

use Illuminate\Database\Seeder;

class BusinessVideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_videos')->delete();

        DB::table('business_videos')->insert([[
        	'id' => 1,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Flat Animated Promotional Video Production',
        	'slug' => 'service-1',
        	'description' => 'Looking for an Promotional Video for your business or website? Well youve come to the right place!.',
        	'type' => 'youtube',
        	'url' => 'https://www.youtube.com/watch?v=b5hiQJFEsjU',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 2,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Animated commercial',
        	'slug' => 'service-1',
        	'description' => 'Film & Animation',
        	'type' => 'youtube',
        	'url' => 'https://www.youtube.com/watch?v=6Map5p3h_po',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 3,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Animated commercial',
        	'slug' => 'service-1',
        	'description' => 'Film & Animation',
        	'type' => 'youtube',
        	'url' => 'https://www.youtube.com/watch?v=6Map5p3h_po',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 4,
        	'user_id' => 9,
        	'business_id' => 5,
        	'title' => 'Animated commercial',
        	'slug' => 'service-1',
        	'description' => 'Film & Animation',
        	'type' => 'youtube',
        	'url' => 'https://www.youtube.com/watch?v=6Map5p3h_po',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 5,
        	'user_id' => 6,
        	'business_id' => 2,
        	'title' => 'Flat Animated Promotional Video Production',
        	'slug' => 'service-1',
        	'description' => 'Looking for an Promotional Video for your business or website? Well youve come to the right place!.',
        	'type' => 'youtube',
        	'url' => 'https://www.youtube.com/watch?v=b5hiQJFEsjU',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 6,
        	'user_id' => 6,
        	'business_id' => 2,
        	'title' => 'Flat Animated Promotional Video Production',
        	'slug' => 'service-1',
        	'description' => 'Looking for an Promotional Video for your business or website? Well youve come to the right place!.',
        	'type' => 'youtube',
        	'url' => 'https://www.youtube.com/watch?v=b5hiQJFEsjU',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 7,
        	'user_id' => 9,
        	'business_id' => 5,
        	'title' => 'Animated commercial',
        	'slug' => 'service-1',
        	'description' => 'Film & Animation',
        	'type' => 'youtube',
        	'url' => 'https://www.youtube.com/watch?v=6Map5p3h_po',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 8,
        	'user_id' => 9,
        	'business_id' => 5,
        	'title' => 'Flat Animated Promotional Video Production',
        	'slug' => 'service-1',
        	'description' => 'Looking for an Promotional Video for your business or website? Well youve come to the right place!.',
        	'type' => 'youtube',
        	'url' => 'https://www.youtube.com/watch?v=b5hiQJFEsjU',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 9,
        	'user_id' => 11,
        	'business_id' => 4,
        	'title' => 'Animated commercial',
        	'slug' => 'service-1',
        	'description' => 'Film & Animation',
        	'type' => 'youtube',
        	'url' => 'https://www.youtube.com/watch?v=6Map5p3h_po',
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	]]);
    }
}
