<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AchievementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('achievements')->insert([
            [
                'name' => 'Jack of All Trades',
                'description' => 'Try every activity at least once. A true multitasker!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Rest Rookie',
                'description' => 'Accumulate a total of 10 hours of rest. A good start towards mastering relaxation.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Rest Enthusiast',
                'description' => 'Achieve 100 hours of rest. You\'re becoming a pro at taking it easy!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Savings Starter',
                'description' => 'Earn your first 1,000 $Rest Bucks. The journey to wealth begins!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Rest Tycoon',
                'description' => 'Amass an impressive 10,000 $Rest Bucks. The ultimate reward for rest mastery!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
