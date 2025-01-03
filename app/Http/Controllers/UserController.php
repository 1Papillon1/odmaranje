<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;
use App\Models\User;
use App\Models\Activity;
use App\Models\Reward;
use Illuminate\Contracts\View\View;
use DB;
use Log;

class UserController extends Controller
{
   
     public function index(): View
     {

        // Log user in
        Log::info('User ' . auth()->id() . ' visited the index homepage.');

         $activeActivityId = UserActivity::where('user_id', auth()->id())
            ->where('status', 'active')
            ->value('id') ?? null;

      


        return view('user.index', compact('activeActivityId'));

        
     }

     public function notifications(): View
     {
        

        return view('user.notifications');
     }
 
   
     public function profile(): View
     {

       
         return view('user.profile'); 
     }

     public function coins(): View
     {
       
         return view('user.coins'); 
     }

     public function achievements(): View
     {
        
         return view('user.achievements'); 
     }


     public function faq(): View
     {
       
         return view('user.faq'); 
     }

     public function calendar(): View 
     {
        
         return view('user.calendar');
     }

     public function events(): View 
     {
       
        $user = Auth::user();
        $events = DB::table('events')->get();

         return view('user.events', compact('user', 'events'));
     }

     public function rewards(): View 
     {
       
    
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

     public function roadmap(): View 
     {
       
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
