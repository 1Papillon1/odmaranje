<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Notifications;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        for ($i = 1; $i <= 15; $i++) {
            DB::table('notifications')->insert([
                'user_id' => 2,
                'title' => 'Notification ' . $i,
                'message' => 'Notification message ' . $i,
                'type' => 'task_started',
                'is_read' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

    }
}
