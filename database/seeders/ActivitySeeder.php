<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    public function run()
    {
        $activities = [
            [
                'name' => 'Walking',
                'description' => 'A short walk to clear your mind.',
                'energy_change' => 10,
                'duration' => 30 // trajanje u minutama
            ],
            [
                'name' => 'Meditation',
                'description' => 'Relax with guided meditation.',
                'energy_change' => 20,
                'duration' => 15
            ],
            [
                'name' => 'Reading',
                'description' => 'Read a book or an article.',
                'energy_change' => 15,
                'duration' => 45
            ],
            [
                'name' => 'Workout',
                'description' => 'Physical activity to boost energy.',
                'energy_change' => 30,
                'duration' => 60
            ],
            [
                'name' => 'Cooking',
                'description' => 'Prepare a healthy meal.',
                'energy_change' => 15,
                'duration' => 60
            ],
            [
                'name' => 'Gardening',
                'description' => 'Relax while taking care of your plants.',
                'energy_change' => 25,
                'duration' => 45
            ],
            [
                'name' => 'Painting',
                'description' => 'Express yourself through art.',
                'energy_change' => 20,
                'duration' => 120
            ],
            [
                'name' => 'Gaming',
                'description' => 'Enjoy some leisure time playing video games.',
                'energy_change' => 10,
                'duration' => 90
            ],
            [
                'name' => 'Hobby',
                'description' => 'Work on your favorite hobby.',
                'energy_change' => 20,
                'duration' => 60
            ],
            [
                'name' => 'Power Nap',
                'description' => 'Recharge with a quick nap.',
                'energy_change' => 30,
                'duration' => 20
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }
}
