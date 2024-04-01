<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Illuminate\Support\Facades\File;

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
        // 从环境变量读取JSON字符串
        $googleCredentialsJson = env('GOOGLE_APPLICATION_CREDENTIALS');

        // 创建临时文件并写入JSON字符串
        if ($googleCredentialsJson) {
            $tempFilePath = tempnam(sys_get_temp_dir(), 'gcp_');
            File::put($tempFilePath, $googleCredentialsJson);

            // 更新环境变量指向临时文件
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $tempFilePath);
        }
    }
}
