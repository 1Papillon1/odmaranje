<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use LogViewer; //alias za \Opcodes\LogViewer\Facades\LogViewer

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        // bez middlware autorizacije - dozvola za sve

        LogViewer::auth(function () {
            // Omogućuje pristup svim zahtjevima bez autorizacije
            return true;
        });
    }
}
