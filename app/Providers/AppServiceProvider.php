<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \App\Models\Dokter::observe(\App\Observers\DokterObserver::class);
        \App\Models\Pasien::observe(\App\Observers\PasienObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
    }
}
