<?php

namespace App\Livewire\Components\User;

use Livewire\Component;
use Livewire\WithPagination; 
use App\Models\Notifications as Notification; 


class Notifications extends Component
{

    use WithPagination;

 

    public function render()
    {
        
        $notifications = Notification::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(10);


        return view('livewire.components.user.notifications', [
            'notifications' => $notifications
        ]);
    }
}
