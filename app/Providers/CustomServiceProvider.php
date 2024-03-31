<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $relativePath = 'storage/app/keys/dialogflow.json';
        $absolutePath = base_path($relativePath);
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$absolutePath");
    }
}
