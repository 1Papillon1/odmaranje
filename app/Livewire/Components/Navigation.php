<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Notifications;

class Navigation extends Component
{
   
     public $dropdownOpen = false; 
     public $isOpen = false;       
     public $notifications;
  
        
     public function mount() 
     {
        $this->getNotifications();
     }
   
    public function getNotifications() {
        $this->notifications = Notifications::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
    }
     
 
     public function toggleDropdown()
     {
         $this->dropdownOpen = !$this->dropdownOpen;
     }
 
     public function toggleHamburger()
     {
         $this->isOpen = !$this->isOpen;
     }


    public function render()
    {
       
        
        return view('livewire.components.navigation', [
            'notifications' => $this->notifications
        ]);
    }
}
