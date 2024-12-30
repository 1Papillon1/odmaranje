<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Korisnik koji prima notifikaciju
            $table->string('title'); // Naslov notifikacije
            $table->text('message'); // Detaljna poruka
            $table->enum('type', [
                'task_started',
                'task_completed',
                'task_failed',
                'daily_reward_claimed',
                'daily_reward_ready',
                'event_started',
                'event_ending_soon',
                'event_reward_claimed',
                'level_up',
                'xp_earned',
                'system_update',
                'new_feature',
                'low_energy',
                'energy_full',
                'rest_bucks_earned',
                'rest_bucks_goal_reached',
                'custom_message'
            ]); // Tip notifikacije
            $table->boolean('is_read')->default(false); // Oznaka je li notifikacija pročitana
            $table->timestamps(); // Timestamps za created_at i updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
