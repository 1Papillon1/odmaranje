<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Log;


class AuthController extends Controller
{

    public function home() 
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        return view('authorization.choice');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        return view('authorization.login');
    }


    public function login(Request $request)
    {
     
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        

if (Auth::attempt($credentials)) {
    $request->session()->regenerate();

    $user = Auth::user();
    $today = Carbon::now();

  
    $dailyReward = DB::table('daily_rewards')
        ->where('user_id', $user->id)
        ->orderBy('reward_date', 'desc')
        ->first();

    $streak = 1; 
    $canClaimReward = false;

    if ($dailyReward) {
        $lastRewardDate = Carbon::parse($dailyReward->reward_date);

        if ($lastRewardDate->diffInHours($today) >= 24) {
            $canClaimReward = true;

          
            if ($lastRewardDate->isYesterday()) {
                $streak = min($dailyReward->streak + 1, 7);
            } else {
               
                $streak = 1;
            }

          
            DB::table('daily_rewards')
                ->where('id', $dailyReward->id)
                ->update([
                    'reward_date' => $today->toDateTimeString(),
                    'streak' => $streak,
                    'updated_at' => now(),
                ]);
        }
    } else {
      
        $canClaimReward = true;

        DB::table('daily_rewards')->insert([
            'user_id' => $user->id,
            'reward_date' => $today->toDateTimeString(),
            'streak' => $streak,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    if ($canClaimReward) {

        $rewards = [10, 20, 30, 40, 50, 60, 70];
        $restBucks = $rewards[$streak - 1];
        $user->increment('rest_bucks', $restBucks);
    }


    return redirect()->route('user.profile');
}


if (User::where('email', $request->email)->exists()) {
    return back()->withErrors(['password' => 'The password is incorrect.'])->withInput();
}
    

        return back()->withErrors(['email' => 'The email does not exist.'])->withInput();
    }

 
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        return view('authorization.register');
    }

    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      
                'regex:/[A-Z]/',   
                'regex:/[0-9]/',   
            ],
        ], [
            'password.regex' => 'The password must include at least one lowercase letter, one uppercase letter, and one digit.',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'energy' => 0,
            'password' => Hash::make($request->password),
        ]);
    
     
        DB::table('user_role')->insert([
            'user_id' => $user->id,
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user->achievements()->attach(1);
    
        Auth::login($user);
    
        return redirect()->route('user.profile')->with('success', 'Welcome! Your account has been created.');
    }

  
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('guest.home');
    }
}