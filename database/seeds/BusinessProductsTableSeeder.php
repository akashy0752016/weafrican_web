<?php

use Illuminate\Database\Seeder;

class BusinessProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_products')->delete();

        DB::table('business_products')->insert([[
        	'id' => 1,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Product 1',
        	'slug' => 'product-1',
        	'description' => 'Product 1',
        	'price' => 200,
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 2,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Product 2',
        	'slug' => 'product-2',
        	'description' => 'Product 2',
        	'price' => 200,
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 3,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Product 3',
        	'slug' => 'product-3',
        	'description' => 'Product 3',
        	'price' => 200,
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 4,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Product 4',
        	'slug' => 'product-4',
        	'description' => 'Product 4',
        	'price' => 200,
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 5,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Product 5',
        	'slug' => 'product-5',
        	'description' => 'Product 5',
        	'price' => 200,
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 6,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Product 6',
        	'slug' => 'product-6',
        	'description' => 'Product 6',
        	'price' => 200,
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        	],[
        	'id' => 7,
        	'user_id' => 5,
        	'business_id' => 1,
        	'title' => 'Product 7',
        	'slug' => 'product-7',
        	'description' => 'Product 7',
        	'price' => 200,
        	'is_blocked' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
    }
}
