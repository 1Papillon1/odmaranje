<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementsSeeder extends Seeder
{
   
    public function run(): void
    {

        // add achievemnts for rest application (users manage their rest and activities)
        // description and name

        DB::table('achievements')->insert([
            [
                'name' => 'Successfully Registered',
                'description' => "Welcome to the community! You've successfully joined Rest.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'First Rest',
                'description' => "You've taken your first break with us. Here's to more relaxation ahead!",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '1 Hour of Rest',
                'description' => "You've completed a total of 1 hour of rest. Keep it up!",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


    }
}
