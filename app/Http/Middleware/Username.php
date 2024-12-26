<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class Username
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
       

        if (Auth::check()) {
            
            
            $name = DB::table('users')->where('id', Auth::user()->id)->value('name');
           

            // Možeš dodati korisničko ime u request
            $request->merge(['username' => $name]);

            // Ili ga možeš dijeliti sa svim view-ovima
            view()->share('username', $name);
        }

        return $next($request);
    }
}
