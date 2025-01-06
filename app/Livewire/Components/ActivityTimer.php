<?php

namespace App\Livewire\Components;


use App\Models\UserActivity;
use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\UserAchievement;


class ActivityTimer extends Component
{
    public $user_activity;
    public $user;
    public $activity;
    public $remaining_time; 
    public $progress;
    public $restBucksChange;
    public $activityDuration = 0;


    protected function unlockAchievement($user, $achievementId, $message, $type = 'custom_message')
    {
        

        $hasAchievement = UserAchievement::where('achievement_id', $achievementId)->exists();
        if (!$hasAchievement) {
     
            UserAchievement::create([
                'user_id' => $user->id,
                'achievement_id' => $achievementId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->sendNotification($user, 'Achievement Unlocked!', $message, $type);
        } 


    }
    
        protected function sendNotification($user, $title, $message, $type)
        {
            $user->notifications()->create([
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'is_read' => false,
            ]);
        }
        

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

            $maxEnergy = 96;

    
            $currentEnergy = auth()->user()->energy;

           
            $energyToRecover = $maxEnergy - $currentEnergy;

           
            $minutesPer10Energy = 60; 
            $durationMinutes = ($energyToRecover / 10) * $minutesPer10Energy;

            $this->activityDuration = $durationMinutes;
        } else {
            $this->activityDuration = $this->activity->duration;
        }
        
        
       
      
       $this->calculateRestBucks($this->activity->id);

     
      
       

        if ($this->user_activity) {
            $this->updateRemainingTime();
        }
    }

    public function calculateRestBucks($activityId) 
    {
        $user = User::find(auth()->id());

        

        $activity = Activity::find($activityId);

      

        if ($activity->type == 'add') {
            if ($activity->name == 'Sleep') {
                $activity->energy_change = 96 - $user->energy;

            } 

            
            $energy_change = $activity->energy_change;
            $balanceMultiplier = $user->calculateMultiplier();
            $energyMultiplier = $user->calculateEnergyMultiplier();

            $totalMultiplier = $balanceMultiplier * $energyMultiplier;

            $restBucksChange = 1 * $energy_change * $totalMultiplier;
          
            $this->restBucksChange = round($restBucksChange, 0);
           
        } else {
            $this->restBucksChange = 0;
        }
        
    }

   

    

    public function updateRemainingTime()
    {
        if ($this->user_activity) {

            


            $createdAt = Carbon::parse($this->user_activity->created_at);
            $totalDurationMinutes = $this->user_activity->remaining_time;
            $elapsedMinutes = $createdAt->diffInMinutes(Carbon::now());
    
           
            $this->remaining_time = round(max(0, $totalDurationMinutes - $elapsedMinutes), 0);
    
           
            $this->progress = ($totalDurationMinutes > 0)
                ? (($this->remaining_time / $totalDurationMinutes) * 100)
                : 0;
    
          
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
                    $user->update(['energy' => max(0, $user->energy - $energy_change)]);
                }


                $this->user->updateXp($energy_change);
    
                $this->user_activity->update(['status' => 'completed']);
    
         
                $restActivities = ['Meditation', 'Power Nap', 'Sleep'];
    
                if (in_array($activity->name, $restActivities)) {
                    $this->unlockAchievement(
                        $user,
                        2,
                        'You unlocked achievement #2 for completing your first rest activity.'
                    );
                }

              
                $totalRestTime = UserActivity::where('user_id', $user->id) 
                ->whereIn('activity_id', Activity::whereIn('name', $restActivities)->pluck('id')) 
                ->where('status', 'completed') 
                ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, created_at, updated_at)'));

                if ($totalRestTime >= 60) {
                    $this->unlockAchievement(
                        $user,
                        3,
                        'You unlocked achievement #3 for 1 hour of total rest activities.'
                    );
                }

             
                $allActivitiesCompleted = Activity::all()->every(function ($activity) use ($user) {
                    return $user->completedAllActivities();
                });

                if ($allActivitiesCompleted) {
                    $this->unlockAchievement(
                        $user,
                        4,
                        'You unlocked achievement #4 for completing each activity at least once.'
                    );
                }

               
                if ($totalRestTime >= 600) {
                    $this->unlockAchievement(
                        $user,
                        5,
                        'You unlocked achievement #5 for 10 hours of total rest activities.'
                    );
                }

             
                if ($totalRestTime >= 6000) {
                    $this->unlockAchievement(
                        $user,
                        6,
                        'You unlocked achievement #6 for 100 hours of total rest activities.'
                    );
                }

              
                if ($user->rest_bucks >= 1000) {
                    $this->unlockAchievement(
                        $user,
                        7,
                        'You unlocked achievement #7 for earning 1000 Rest Bucks.',
                        'rest_bucks_goal_reached'
                    );
                }

              
                if ($user->rest_bucks >= 10000) {
                    $this->unlockAchievement(
                        $user,
                        8,
                        'You unlocked achievement #8 for earning 10,000 Rest Bucks.',
                        'rest_bucks_goal_reached'
                    );
                }
    
                return redirect()->route('user.dashboard');
            }
        }
    }

   
    public function tick()
    {
        
        $this->updateRemainingTime();
    }

    
    protected function getRequiredXPForLevel($level)
{
    $baseXP = 100; 
    $growthFactor = 1.45;

 
    return round($baseXP * pow($growthFactor, $level - 1));
}

public function addXP($xp)
{
    $user = auth()->user();

  
    $user->xp += $xp;

 
    while ($user->xp >= $this->getRequiredXPForLevel($user->level + 1)) {
        $user->level++;
        $user->xp -= $this->getRequiredXPForLevel($user->level);
    }

 
    $user->save();
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