<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\User;

class UserStats extends Component
{

    public $user;
    public $user_activities;
    public $activities;

    public $coin_multiplier;
    public $energy_multiplier;
    public $suggested_activities;

    public function mount()
    {
        $this->user = User::find(auth()->id());

      
        $this->user_activities = $this->user->completedActivitiesCountWithName;
        
      
        $this->activities = $this->user_activities
        ->groupBy(function ($activity) {
            return $activity->activity->name;  
        })
        ->map(function ($group) {
            return [
                'name' => $group->first()->activity->name, 
                'count' => $group->count(),  
            ];
        });

      
        
        $this->coin_multiplier = $this->user->calculateMultiplier();
        $this->energy_multiplier = $this->user->calculateEnergyMultiplier();

        $this->suggested_activities = $this->user->getSuggestedActivities();
  
    }

    public function render()
    {
        return view('livewire.components.user-stats');
    }
}
