<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthorizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Omogućiti prolaz za logout rutu
        if ($request->routeIs('logout')) {
            return $next($request);
        }

        // Ako je korisnik ulogovan i pokušava pristupiti 'guest.*' rutama
        if (Auth::check() && $request->routeIs('guest.*')) {
            return redirect()->route('user.dashboard');
        }

        // Ako korisnik NIJE ulogovan i pokušava pristupiti 'user.*' rutama
        if (!Auth::check() && $request->routeIs('user.*')) {
            return redirect()->route('home');
        }

        // Provjeri da li korisnik ima dozvolu za pristup trenutnoj ruti
           if (Auth::check() && !$this->hasPermission($request)) {
            return response()->view('errors.403', [], 403);
        }

        // Provjeri da li ruta postoji, ako ne, preusmjeri na 404 stranicu
        if (!$request->route()) {
            return response()->view('errors.404', [], 404);
        }


        return $next($request);
    }

    /**
     * Provjeri da li korisnik ima dozvolu za pristup trenutnoj ruti.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasPermission(Request $request): bool
    {
        // Ovdje dodaj logiku za provjeru dozvola korisnika
        // Na primjer, možeš provjeriti ulogu korisnika i rutu
        $user = Auth::user();
        $routeName = $request->route()->getName();

        // Provjeri da li korisnik ima potrebnu ulogu za pristup ruti
        if (!$this->hasRole($user, 'admin') && str_contains($routeName, 'admin')) {
            return false;
        }

        return true;
    }

    /**
     * Provjeri da li korisnik ima određenu ulogu.
     *
     * @param  \App\Models\User  $user
     * @param  string  $role
     * @return bool
     */
    protected function hasRole($user, $role): bool
    {
        return $user->roles()->where('name', $role)->exists();
    }
}
