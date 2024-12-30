<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;
use App\Models\User;
use App\Models\Activity;
use DB;

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
        $user = Auth::user();
        $events = DB::table('events')->get();

         return view('user.events', compact('user', 'events'));
     }

     public function rewards() 
     {
        if (!Auth::check()) {
            return redirect()->route('guest.home');
        }
    
        // Fetch the current user
        $user = Auth::user();
    
        // Fetch current streak and daily rewards
        $currentStreak = DB::table('daily_rewards')
            ->where('user_id', $user->id)
            ->orderBy('reward_date', 'desc')
            ->value('streak') ?? 0;
    
        // Define rewards for each day
        $rewards = [10, 20, 30, 40, 50, 60, 70];
    
        return view('user.rewards', [
            'currentStreak' => $currentStreak,
            'rewards' => $rewards,
        ]);
     }

     public function roadmap() 
     {
        if (!Auth::check()) {
            return redirect()->route('guest.home');
        }
         return view('user.roadmap');
     }


     public function logout(Request $request)
     {
         Auth::logout();
         $request->session()->invalidate();
         $request->session()->regenerateToken();
 
         return redirect()->route('guest.home');
     }
 
}
