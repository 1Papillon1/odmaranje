<?php

namespace App\Livewire\Components;

use App\Models\Achievement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserAchievements extends Component
{
    public $user;
    public $achievements;
    public $user_achievements;

    public function mount()
    {
        $this->user = Auth::user();
        $this->achievements = Achievement::all();

        $this->user_achievements = DB::table('user_achievements')->where('user_id', $this->user->id)->get();


    }


    public function render()
    {
        return view('livewire.components.user-achievements');
    }
}
