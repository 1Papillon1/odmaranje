<?php

namespace App\Livewire\Components;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserCoins extends Component
{
    public $user;
    public $rest_bucks;

    protected $listeners = [
        'refreshCoins' => '$refresh'
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->rest_bucks = $this->user->rest_bucks;
    }

   

    public function render()
    {
        return view('livewire.components.user-coins');
    }
}
