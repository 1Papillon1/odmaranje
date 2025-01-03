<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'name' => 'Rest App Launch',
                'description' => 'We are launching the Rest App! Join us for an exciting event.',
                'reward' => 100,
                'start_time' => now()->addDays(7),
                'end_time' => now()->addDays(14),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
