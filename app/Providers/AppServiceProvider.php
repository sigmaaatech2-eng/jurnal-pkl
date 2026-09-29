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
        // Force HTTPS only in production environment or when behind an HTTPS reverse proxy.
        // Do NOT use APP_URL string matching — that causes redirect loops in local dev
        // when APP_URL is set to the production https:// URL.
        if (! $this->app->runningInConsole()) {
            if (
                $this->app->environment('production') ||
                request()->header('x-forwarded-proto') === 'https'
            ) {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }
        }
    }
}
