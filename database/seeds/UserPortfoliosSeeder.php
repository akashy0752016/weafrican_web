<?php

use Illuminate\Database\Seeder;

class UserPortfoliosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_portfolios')->delete();

        DB::table('user_portfolios')->insert([[
            'id' => 1,
            'user_id' => 5,
            'business_id' => 1,
            'maritial_status' => "Single", 
            'occupation' => "Test", 
            'acedimic_status' => "10",
            'key_skills' => "Test", 
            'experience_years' => "5", 
            'experience_months' => "10", 
            'height_feets' => "5", 
            'height_inches' => "10", 
            'professional_training' => 1, 
            'institute_name' => "Test", 
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 2,
            'user_id' => 11,
            'business_id' => 4,
            'maritial_status' => "Single", 
            'occupation' => "Test", 
            'acedimic_status' => "10",
            'key_skills' => "Test", 
            'experience_years' => "5", 
            'experience_months' => "10", 
            'height_feets' => "5", 
            'height_inches' => "10", 
            'professional_training' => 1, 
            'institute_name' => "Test", 
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
    }
}
