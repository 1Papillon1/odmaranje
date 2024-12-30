<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->booting(function () {
        // Globalno deljenje podataka sa svim view-ovima
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('username', Auth::user()->name);
                $view->with('email', Auth::user()->email);
                
            }
        });
    })->create();
