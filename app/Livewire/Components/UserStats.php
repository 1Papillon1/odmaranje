<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\User;

class UserStats extends Component
{

    public $user;
    public $user_activities;
    public $activities;

    public function mount()
    {
        $this->user = User::find(auth()->id());

        // all activities
        $this->user_activities = $this->user->completedActivitiesCountWithName;
        
        // that user_activities. Get activity name and count
        $this->activities = $this->user_activities
        ->groupBy(function ($activity) {
            return $activity->activity->name;  // Grupisanje po imenu aktivnosti
        })
        ->map(function ($group) {
            return [
                'name' => $group->first()->activity->name, // Uzmi ime iz prve aktivnosti u grupi
                'count' => $group->count(),  // Broj aktivnosti u grupi
            ];
        });

  
    }

    public function render()
    {
        return view('livewire.components.user-stats');
    }
}