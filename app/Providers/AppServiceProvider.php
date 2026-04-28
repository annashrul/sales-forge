<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force https in production (Cloud Run, Forge, etc. terminate TLS upstream).
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
