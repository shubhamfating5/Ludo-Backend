<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

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
         $customDashboardPath = resource_path('views/vendor/laravel-websockets/dashboard.blade.php');

    if (File::exists($customDashboardPath)) {
        View::addNamespace('laravel-websockets', resource_path('views/vendor/laravel-websockets'));
    }
    }
}
