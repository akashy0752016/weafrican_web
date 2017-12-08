<?php

use Illuminate\Database\Seeder;

class EventSeatingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_seating_plans')->delete();

        DB::table('event_seating_plans')->insert([[
            'title' => 'Platinum',
            'description' => 'Platinum',
            'slug' => 'platinum-1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
        	'title' => 'Gold',
            'description' => 'Gold',
            'slug' => 'gold-1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
        	'title' => 'Silver',
            'description' => 'Silver',
            'slug' => 'silver-1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]]);
    }
}
