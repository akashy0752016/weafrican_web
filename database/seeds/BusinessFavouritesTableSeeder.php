<?php

use Illuminate\Database\Seeder;

class BusinessFavouritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_favourites')->delete();
        
        DB::table('business_favourites')->insert([[
        	'id' => 1,
        	'user_id' => 3,
        	'business_id' => 1,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
        	'id' => 2,
        	'user_id' => 7,
        	'business_id' => 1,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
        	'id' => 3,
        	'user_id' => 6,
        	'business_id' => 1,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
    }
}
