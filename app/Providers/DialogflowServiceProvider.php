<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

class DialogflowServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('dialogflow.access_token', function () {
            $scopes = ['https://www.googleapis.com/auth/cloud-platform', 'https://www.googleapis.com/auth/dialogflow'];
            $credentials = ApplicationDefaultCredentials::getCredentials($scopes);
            $authHttpHandler = HttpHandlerFactory::build();
            $authToken = $credentials->fetchAuthToken($authHttpHandler);
            return $authToken['access_token'];
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $credentialsPath = base_path('ssl/' . env('GOOGLE_APPLICATION_CREDENTIALS'));
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $credentialsPath);
    }
}
