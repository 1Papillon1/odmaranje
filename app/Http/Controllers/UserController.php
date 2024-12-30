<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;

class UserController extends Controller
{
   
     public function index()
     {

        

         if (!Auth::check()) {
             return redirect()->route('guest.home');
         }

         $activeActivityId = UserActivity::where('user_id', auth()->id())
            ->where('status', 'active')
            ->value('id') ?? null;

      


        return view('user.index', compact('activeActivityId'));

        
     }

     public function notifications() 
     {
        if (!Auth::check()) {
            return redirect()->route('guest.home');
        }

        return view('user.notifications');
     }
 
   
     public function profile()
     {
        if (!Auth::check()) {
            return redirect()->route('guest.home');
        }
         return view('user.profile'); 
     }

     public function coins()
     {
        if (!Auth::check()) {
            return redirect()->route('guest.home');
        }
         return view('user.coins'); 
     }

     public function achievements()
     {
        if (!Auth::check()) {
            return redirect()->route('guest.home');
        }
         return view('user.achievements'); 
     }


     public function faq()
     {
        if (!Auth::check()) {
            return redirect()->route('guest.home');
        }
         return view('user.faq'); 
     }

     public function calendar() 
     {
        if (!Auth::check()) {
            return redirect()->route('guest.home');
        }
         return view('user.calendar');
     }

     public function events() 
     {
        if (!Auth::check()) {
            return redirect()->route('guest.home');
        }
         return view('user.events');
     }


     public function logout(Request $request)
     {
         Auth::logout();
         $request->session()->invalidate();
         $request->session()->regenerateToken();
 
         return redirect()->route('guest.home');
     }
 
}
