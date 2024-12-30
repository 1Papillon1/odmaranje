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
                return redirect()->route('user.profile');
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
        $user->roles()->attach(1);
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
