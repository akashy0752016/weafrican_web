<?php

use Illuminate\Database\Seeder;

class SecurityQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('security_questions')->delete();
        
        DB::table('security_questions')->insert([[
        	'id' => 1,
            'question' => 'What is the last name of the teacher who gave you your first failing grade?',
            'is_blocked' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
        	'id' => 2,
            'question' => 'What was the name of your elementary / primary school?',
            'is_blocked' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
        	'id' => 3,
            'question' => 'In what city or town does your nearest sibling live?',
            'is_blocked' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
        	'id' => 4,
            'question' => 'What time of the day were you born? (hh:mm)',
            'is_blocked' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
    }
}
