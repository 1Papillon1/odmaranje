<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Navigation extends Component
{

     // dropdown open toggle
     public $dropdownOpen = false; // Za dropdown
     public $isOpen = false;       // Za hamburger meni
 
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
        return view('livewire.components.navigation');
    }
}
