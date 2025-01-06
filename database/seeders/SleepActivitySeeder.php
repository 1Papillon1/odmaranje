<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Activity;

class SleepActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'name' => 'Sleep',
                'description' => 'Rest and rejuvenate by sleeping.',
                'energy_change' => 0,
                'duration' => 0, // trajanje u minutama
            ],
            
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }
}
