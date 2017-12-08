<?php

use Illuminate\Database\Seeder;

class UserBusinessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('user_businesses')->delete();

         DB::table('user_businesses')->insert([[
            'id' => 1,
            'user_id' => 5,
            'business_id' => 'Div999',
            'bussiness_category_id' => 1,
            'title' => 'Bags Business',
            'keywords' => 'Divya',
            'about_us' => 'Divya',
            'website' => 'divyaaxovel.com',
            'is_identity_proof_validate' => 1,
            'is_business_proof_validate' => 1,
            'is_agree_to_terms' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'id' => 2,
            'user_id' => 6,
            'business_id' => 'Aka999',
            'bussiness_category_id' => 3,
            'title' => 'Test Business',
            'keywords' => 'Divya',
            'about_us' => 'Divya',
            'website' => 'akashaxovel.com',
            'is_identity_proof_validate' => 1,
            'is_business_proof_validate' => 1,
            'is_agree_to_terms' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'id' => 3,
            'user_id' => 7,
            'business_id' => 'Juhi999',
            'bussiness_category_id' => 2,
            'title' => 'parlour',
            'keywords' => 'Divya',
            'about_us' => 'Divya',
            'website' => 'juhiaxovel.com',
            'is_identity_proof_validate' => 1,
            'is_business_proof_validate' => 1,
            'is_agree_to_terms' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'id' => 4,
            'user_id' => 11,
            'business_id' => 'mad999',
            'bussiness_category_id' => 1,
            'title' => 'Test Business',
            'keywords' => 'Divya',
            'about_us' => 'Divya',
            'website' => 'testBusiness.com',
            'is_identity_proof_validate' => 1,
            'is_business_proof_validate' => 1,
            'is_agree_to_terms' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
            'id' => 5,
            'user_id' => 9,
            'business_id' => 'rah999',
            'bussiness_category_id' => 2,
            'title' => 'Test Business',
            'keywords' => 'Divya',
            'about_us' => 'Divya',
            'website' => 'testBusiness.com',
            'is_identity_proof_validate' => 1,
            'is_business_proof_validate' => 1,
            'is_agree_to_terms' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
    }
}
