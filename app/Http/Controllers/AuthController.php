<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


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
    
        // Proveri da li korisnik sa ovim e-mailom postoji
        $userExists = User::where('email', $request->email)->exists();
    
        if ($userExists) {
            // Ako e-mail postoji, pokušaj prijavu
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('user.dashboard');
            }
    
            // Ako lozinka nije tačna
            return back()->withErrors(['password' => 'The password is incorrect.'])->withInput();
        }
    
        // Ako e-mail ne postoji
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
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'energy' => 0,
            'password' => Hash::make($request->password),
        ]);

        // roles
        $user->roles()->attach(1);

        // use db user_achievement where achievement id 1
        $user->achievements()->attach(1);
        

        Auth::login($user);

        return redirect()->route('user.dashboard');
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
