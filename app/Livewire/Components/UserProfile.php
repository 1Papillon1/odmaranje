<?php

namespace App\Livewire\Components;

use Livewire\Component;

class UserProfile extends Component
{
    public $name;
    public $email;
    public $password;
    public $user;
   

    public $editField = null; // Tracks which field is being edited

    public function mount()
    {

        $this->user = auth()->user();

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->password = $this->user->password;

    }

    public function startEditing($field)
    {
        $this->editField = $field;
    }

    public function save($field)
    {
      

        $this->validate([
            $field => match($field) {
                'name' => 'required|min:3',
                'email' => 'required|email',
                'password' => 'required|min:6',
                default => '',
            },
        ]); 
    
        if ($field === 'password') {
            $this->user->update([
                $field => bcrypt($this->$field), // Šifruj lozinku
            ]);
        } else {
            $this->user->update([
                $field => $this->$field,
            ]);
        }
    
        session()->flash('message', ucfirst($field) . ' updated successfully.');
    
        $this->editField = null; // Zaustavlja uređivanje
    }

    public function render()
    {
        return view('livewire.components.user-profile');
    }
}
