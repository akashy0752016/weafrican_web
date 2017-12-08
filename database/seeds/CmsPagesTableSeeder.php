<?php

use Illuminate\Database\Seeder;

class CmsPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cms_pages')->delete();
        
        DB::table('cms_pages')->insert([
        	['title' => 'Privacy Policy', 'slug' => 'privacy-policy', 'content' => '', 'created_at' => date('Y-m-d H:i:s'),  'updated_at' => date('Y-m-d H:i:s')],
        	['title' => 'Terms of Use', 'slug' => 'terms-of-use', 'content' => '', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['title' => 'FAQ', 'slug' => 'faq', 'content' => '', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['title' => 'Terms & Conditons', 'slug' => 'terms-and-conditions', 'content' => '', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}
