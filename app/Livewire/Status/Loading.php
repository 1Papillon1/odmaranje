<?php

namespace App\Livewire\Status;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Loading extends Component
{
    public $progress = 0;

  
    public function updateProgress()
    {
        if ($this->progress < 100) {
            $this->progress += 100;
        } else {
            // Redirect based on authentication status
            if (Auth::check()) {
                // Korisnik je ulogiran - redirect na dashboard
                $this->redirectRoute('user.dashboard');
            } else {
                // Korisnik nije ulogiran - redirect na choice
                $this->redirectRoute('guest.choice');
            }
        }
    }
    
    public function render()
    {
        return view('livewire.status.loading');
    }
}
