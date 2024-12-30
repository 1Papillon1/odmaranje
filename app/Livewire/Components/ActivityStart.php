<?php

namespace App\Livewire\Components;

use App\Models\Activity;
use App\Models\UserActivity;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ActivityStart extends Component
{
    protected $listeners = [
        'start' => '$refresh'
    ];

    protected function sendNotification($user, $title, $message, $type)
    {
        $user->notifications()->create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'is_read' => false,
        ]);
    }

    public $activities = [];
    public $currentIndex = 0;
    public $activeActivityId;
    public $restBucksChange = 0;
    public $user;
    
    public function mount()
    {
        $this->activities = Activity::all(); 
        $this->user = User::find(auth()->id()); 
        
        $this->currentIndex = $this->activities->search(function ($activity) {
            return $activity->id === $this->activeActivityId;
        });

       
       
    }

   

    public function startActivity()
    {
        $activity = Activity::find($this->activeActivityId);
    
        if ($activity) {
            $user = auth()->user();
    
            if ($activity->type == 'add' && $user->energy + $activity->energy_change > 96) {
                session()->flash('message', 'You cannot start this activity, because your energy is too high');
            } else if ($activity->type == 'subtract' && $user->energy - $activity->energy_change < 0) {
                session()->flash('message', 'You cannot start this activity, because your energy is too low');
            } else {


                
                DB::table('user_activities')->insert([
                    'user_id' => $user->id,
                    'activity_id' => $activity->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'remaining_time' => $activity->duration,
                    'status' => 'active',
                ]);
    
          
                $this->sendNotification(
                    $user,
                    'Activity Started',
                    "You have started the activity: {$activity->name}.",
                    'task_started'
                );
    
                session()->flash('message', 'Activity started successfully');
            }
    
         
           
        }
    
        return redirect()->route('user.dashboard');
    }

    public function calculateRestBucks($activityId) 
    {
        $user = User::find(auth()->id());
        $activity = Activity::find($activityId)->first();

      

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


    
    public function rotateRight() {
        $this->currentIndex = ($this->currentIndex + 1) % count($this->activities);
        $this->activeActivityId = $this->activities[$this->currentIndex]->id;
        $this->calculateRestBucks($this->activities[$this->currentIndex]);
      
    }

    public function rotateLeft() {
        $this->currentIndex = ($this->currentIndex - 1 + count($this->activities)) % count($this->activities);
        $this->activeActivityId = $this->activities[$this->currentIndex]->id;
        $this->calculateRestBucks($this->activities[$this->currentIndex]);
    }

    public function render()
    {
        return view('livewire.components.activity-start', [
            'activities' => $this->activities
        ]);
    }
}
