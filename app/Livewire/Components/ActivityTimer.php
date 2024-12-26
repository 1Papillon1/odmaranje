<?php

namespace App\Livewire\Components;


use App\Models\UserActivity;
use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ActivityTimer extends Component
{
    public $user_activity;
    public $user;
    public $activity;
    public $remaining_time; // Remaining time in minutes
    public $progress; // Progress bar width

    public function mount($activity_id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->user = auth()->user();

        // Fetch user activity
        $this->user_activity = UserActivity::find($activity_id);

        $this->activity = Activity::find($this->user_activity->activity_id);
        
        
        if ($this->activity->name == 'Sleep') {
            $this->activity->energy_change = 96 - $this->user->energy;
        }

        
      


        if ($this->user_activity) {
            $this->updateRemainingTime();
        }
    }

   

    // Update remaining time and progress

    public function updateRemainingTime()
{
    if ($this->user_activity) {
        $createdAt = Carbon::parse($this->user_activity->created_at);
        $totalDurationMinutes = $this->user_activity->remaining_time;
        $elapsedMinutes = $createdAt->diffInMinutes(Carbon::now());

        // Računanje preostalog vremena
        $this->remaining_time = round(max(0, $totalDurationMinutes - $elapsedMinutes), 0);

        // Izračunaj progres na osnovu preostalog vremena
        $this->progress = ($totalDurationMinutes > 0)
            ? (($this->remaining_time / $totalDurationMinutes) * 100)
            : 0;

        // Ako je vrijeme isteklo, postavi status na 'completed' i izvrši promene
        if ($this->remaining_time <= 0 && $this->user_activity->status !== 'completed') {
            $activity = Activity::find($this->user_activity->activity_id);
            $energy_change = $activity->energy_change;
            $type = $activity->type;

            $user = User::find(auth()->id());

            if ($type == 'add') {
                $balanceMultiplier = $user->calculateMultiplier();
                $energyMultiplier = $user->calculateEnergyMultiplier();
                $totalMultiplier = $balanceMultiplier * $energyMultiplier;

                $restBucksChange = 1 * $energy_change * $totalMultiplier;
                $restBucksChange = round($restBucksChange, 0);

                DB::table('users')->where('id', auth()->id())->update([
                    'energy' => min(96, $user->energy + $energy_change),
                    'rest_bucks' => $user->rest_bucks + $restBucksChange,
                ]);
            } else {
                $user->update(['energy' => $user->energy - $energy_change]);
            }

            $this->user_activity->update(['status' => 'completed']);

            // Provera za prvu "rest" aktivnost
            $restActivities = ['Meditation', 'Power Nap', 'Sleep'];
            if (in_array($activity->name, $restActivities)) {
                $hasAchievement2 = $user->achievements()->where('achievement_id', 2)->exists();
                if (!$hasAchievement2) {
                    $user->achievements()->attach(2); // Attach achievement with ID 2
                }
            }

            // Provera ukupnog trajanja "rest" aktivnosti za achievement 3
            $totalRestTime = $user->activities()
                ->whereIn('name', $restActivities)
                ->where('status', 'completed')
                ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, created_at, updated_at)'));

            if ($totalRestTime >= 60) {
                $hasAchievement3 = $user->achievements()->where('achievement_id', 3)->exists();
                if (!$hasAchievement3) {
                    $user->achievements()->attach(3); // Attach achievement with ID 3
                }
            }

            return redirect()->route('user.dashboard');
        }
    }
}

    
    public function tick()
    {
        // Ažuriraj preostalo vreme i progres svakog minuta
        $this->updateRemainingTime();
    }

    public function render()
    {
        return view('livewire.components.activity-timer', [
            'remaining_time' => $this->remaining_time,
            'activity' => $this->activity,
            'user_activity' => $this->user_activity,
            'progress' => $this->progress,
        ]);
    }
}