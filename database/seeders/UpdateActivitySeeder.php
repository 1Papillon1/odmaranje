<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateActivitySeeder extends Seeder
{
    public function run()
    {
        $activities = [
            ['name' => 'Walking', 'energy_change' => 3, 'type' => 'subtract'],
            ['name' => 'Meditation', 'energy_change' => 2, 'type' => 'add'],
            ['name' => 'Reading', 'energy_change' => 2, 'type' => 'subtract'],
            ['name' => 'Workout', 'energy_change' => 6, 'type' => 'subtract'],
            ['name' => 'Cooking', 'energy_change' => 4, 'type' => 'subtract'],
            ['name' => 'Gardening', 'energy_change' => 4, 'type' => 'subtract'],
            ['name' => 'Painting', 'energy_change' => 3, 'type' => 'subtract'],
            ['name' => 'Gaming', 'energy_change' => 3, 'type' => 'subtract'],
            ['name' => 'Hobby', 'energy_change' => 3, 'type' => 'subtract'],
            ['name' => 'Power Nap', 'energy_change' => 32, 'type' => 'add'],
        ];

        foreach ($activities as $activity) {
            DB::table('activities')
                ->where('name', $activity['name'])
                ->update([
                    'energy_change' => $activity['energy_change'],
                    'type' => $activity['type'],
                ]);
        }
    }
}
