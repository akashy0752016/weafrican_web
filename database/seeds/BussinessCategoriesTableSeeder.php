<?php

use Illuminate\Database\Seeder;

class BussinessCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bussiness_categories')->delete();
        
        DB::table('bussiness_categories')->insert([
        	['id' => 1,'title' => 'Media & Entertainment', 'slug' => 'media-&-entertainment', 'description' => 'Entertainment','image' => 'cf02abe0ef5b9f8e429b6689ebc6ec7e.jpg','is_blocked' => 0,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
           ['id' => 2,'title' => 'Skilled Professional', 'slug' => 'skilled-professional', 'description' => 'Skilled Professional','image' => '3d0e787630bf396dd2213b6035224665.jpeg','is_blocked' => 0,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
	        ['id' => 3,'title' => 'category3', 'slug' => 'category-3', 'description' => 'grrftrtyrtyrtyr','image' => '36c26a20f7d5cbe7ed1e5d0a591a3770.jpeg','is_blocked' => 0,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}
