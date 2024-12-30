<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



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

    // Obrada login zahtjeva
    public function login(Request $request)
    {
        // Validacija inputa
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Pokušaj autentifikacije korisnika
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            $user = Auth::user();
            $today = Carbon::today()->toDateString();
    
            // Dohvati ili kreiraj dnevnu nagradu
            $dailyReward = DB::table('daily_rewards')
                ->where('user_id', $user->id)
                ->orderBy('reward_date', 'desc')
                ->first();
    
            $streak = 1; // Podrazumevani streak ako nema prethodnih nagrada
    
            if ($dailyReward) {
                // Ako je poslednja nagrada od juče, povećaj streak
                if (Carbon::parse($dailyReward->reward_date)->diffInDays($today) === 1) {
                    $streak = min($dailyReward->streak + 1, 7);
                } elseif (Carbon::parse($dailyReward->reward_date)->diffInDays($today) > 1) {
                    // Resetuj streak ako nije uzastopno
                    $streak = 1;
                }
    
                // Ažuriraj dnevnu nagradu
                DB::table('daily_rewards')
                    ->where('id', $dailyReward->id)
                    ->update([
                        'reward_date' => $today,
                        'streak' => $streak,
                        'updated_at' => now(),
                    ]);
            } else {
                // Kreiraj novu nagradu ako ne postoji nijedna
                DB::table('daily_rewards')->insert([
                    'user_id' => $user->id,
                    'reward_date' => $today,
                    'streak' => $streak,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            // Dodaj nagradu korisniku
            $rewards = [10, 20, 30, 40, 50, 60, 70];
            $restBucks = $rewards[$streak - 1];
            $user->increment('rest_bucks', $restBucks);
    
            // Preusmjeri korisnika na profilnu stranicu
            return redirect()->route('user.profile');
        }
    
        // Ako autentifikacija nije uspjela, provjeri postoji li korisnik s ovim e-mailom
        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors(['password' => 'The password is incorrect.'])->withInput();
        }
    
        // Ako korisnik s ovim e-mailom ne postoji
        return back()->withErrors(['email' => 'The email does not exist.'])->withInput();
    }

    // Prikaz registracijske forme
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        return view('authorization.register');
    }

    // Obrada registracije
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
                'regex:/[a-z]/',      // must include at least one lowercase letter
                'regex:/[A-Z]/',      // must include at least one uppercase letter
                'regex:/[0-9]/',      // must include at least one digit
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
    
        // Attach default role and achievement
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

    // Logout korisnika
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();

        return redirect()->route('guest.home');
    }
}
