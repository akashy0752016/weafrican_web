<?php

use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_categories')->delete();

        DB::table('event_categories')->insert([[
        	'id' => 1,
            'title' => 'Dance',
            'slug' => 'platinum-1',
            'description' => 'Platinum',
            'is_blocked' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
        	'id' => 2,
        	'title' => 'Music',
            'slug' => 'music-1',
            'description' => 'Platinum',
            'is_blocked' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
        	'id' => 3,
        	'title' => 'Concert',
            'slug' => 'concert-1',
            'description' => 'Platinum',
            'is_blocked' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
    }
}
