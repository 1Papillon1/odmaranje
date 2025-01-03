<?php

namespace App\Livewire\Components;

use App\Models\Activity;
use App\Models\UserActivity;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Log;
use Illuminate\Support\Facades\Auth;
use Exception;


class ActivityStart extends Component
{
    protected $listeners = [
        'start' => '$refresh'
    ];

    protected function sendNotification($user, $title, $message, $type)
    {
        

        try {
            $user->notifications()->create([
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            // Handle the exception
            Log::error('Error sending notification: ' . $e->getMessage());
        }
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
        try {
            $activity = Activity::find($this->activeActivityId);
    
            if ($activity) {
                $user = auth()->user();
    
                if ($activity->type == 'add' && $user->energy + $activity->energy_change > 96) {
                    session()->flash('message', 'You cannot start this activity, because your energy is too high');
                } else if ($activity->type == 'subtract' && $user->energy - $activity->energy_change < 0) {
                    session()->flash('message', 'You cannot start this activity, because your energy is too low');
                } else {
                    try {
                        DB::table('user_activities')->insert([
                            'user_id' => $user->id,
                            'activity_id' => $activity->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'remaining_time' => $activity->duration,
                            'status' => 'active',
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Error inserting user activity', ['message' => $e->getMessage()]);
                        session()->flash('message', 'Failed to start activity. Please try again.');
                        return redirect()->route('user.dashboard');
                    }
    
                    try {
                        $this->sendNotification(
                            $user,
                            'Activity Started',
                            "You have started the activity: {$activity->name}.",
                            'task_started'
                        );
                    } catch (\Exception $e) {
                        Log::error('Error sending notification', ['message' => $e->getMessage()]);
                    }
    
                    session()->flash('message', 'Activity started successfully');
                }
            } else {
                session()->flash('message', 'Activity not found.');
            }
    
        } catch (\Exception $e) {
            Log::error('Error in startActivity method', ['message' => $e->getMessage()]);
            session()->flash('message', 'An error occurred while starting the activity.');
        }
    
        return redirect()->route('user.dashboard');
    }

    public function calculateRestBucks($activityId)
    {
        try {
            $user = User::find(auth()->id());
            $activity = Activity::find($activityId);
    
            if (!$user || !$activity) {
                Log::warning('User or Activity not found', ['user_id' => auth()->id(), 'activity_id' => $activityId]);
                $this->restBucksChange = 0;
                return;
            }
    
            if ($activity->type == 'add') {
                if ($activity->name == 'Sleep') {
                    $activity->energy_change = 96 - $user->energy;
                }
    
                try {
                    $energy_change = $activity->energy_change;
                    $balanceMultiplier = $user->calculateMultiplier();
                    $energyMultiplier = $user->calculateEnergyMultiplier();
    
                    $totalMultiplier = $balanceMultiplier * $energyMultiplier;
                    $restBucksChange = 1 * $energy_change * $totalMultiplier;
    
                    $this->restBucksChange = round($restBucksChange, 0);
                } catch (\Exception $e) {
                    Log::error('Error calculating rest bucks', ['message' => $e->getMessage()]);
                    $this->restBucksChange = 0;
                }
            } else {
                $this->restBucksChange = 0;
            }
    
        } catch (\Exception $e) {
            Log::error('Error in calculateRestBucks method', ['message' => $e->getMessage()]);
            $this->restBucksChange = 0;
        }
    }


    
    public function rotateRight()
    {
        

        try {
            if (empty($this->activities)) {
                Log::warning('Activities array is empty or invalid.');
                return;
            }

            $this->currentIndex = ($this->currentIndex + 1) % count($this->activities);
            $this->activeActivityId = $this->activities[$this->currentIndex]->id;
           

            try {
                $this->calculateRestBucks($this->activeActivityId);
            } catch (\Exception $e) {
                Log::error('Error in calculateRestBucks during rotateRight', ['message' => $e->getMessage()]);
            }
        } catch (\Exception $e) {
            Log::error('Error in rotateRight method', ['message' => $e->getMessage()]);
        }
    }

    public function rotateLeft()
    {
        try {
            if (empty($this->activities)) {
                Log::warning('Activities array is empty or invalid.');
                return;
            }

            $this->currentIndex = ($this->currentIndex - 1 + count($this->activities)) % count($this->activities);
            $this->activeActivityId = $this->activities[$this->currentIndex]->id;

            try {
                $this->calculateRestBucks($this->activeActivityId);
            } catch (\Exception $e) {
                Log::error('Error in calculateRestBucks during rotateLeft', ['message' => $e->getMessage()]);
            }
        } catch (\Exception $e) {
            Log::error('Error in rotateLeft method', ['message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.components.activity-start', [
            'activities' => $this->activities
        ]);
    }
}
