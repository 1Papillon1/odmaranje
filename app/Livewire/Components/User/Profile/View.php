<?php

namespace App\Livewire\Components\User\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;

class View extends Component
{

    protected function sendNotification($user, $title, $message, $type)
    {
        $user->notifications()->create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'is_read' => false,
        ]);
    }

    public $user;
    public $user_level;
    public $user_xp;

    public $password_hidden;

    public $level_xp;

    public $current_xp;

    public $editField = null;
    public $name;
    public $email;
    public $password;

 

    

    public function mount()
    {
        $this->user = User::find(auth()->id());
        $this->name = $this->user->name;
        $this->email = $this->user->email;

        $this->user_level = $this->user->level;

        $this->user_xp = $this->user->xp;
        $this->level_xp = ($this->user_level + 1) * 10;

        $this->current_xp = $this->user_xp / $this->level_xp * 100;

        $this->password_hidden = str_repeat('*', 6);

        


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
    
        // Dodavanje notifikacije nakon ažuriranja profila
        $this->sendNotification(
            $this->user,
            'Profile Updated',
            ucfirst($field) . ' has been updated successfully.',
            'custom_message'
        );
    
        session()->flash('success', ucfirst($field) . ' updated successfully.');
    
        $this->editField = null; // Zaustavlja uređivanje
    }
    


    


    public function render()
    {
        return view('livewire.components.user.profile.view');
    }
}
