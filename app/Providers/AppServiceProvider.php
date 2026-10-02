<?php

namespace App\Providers;

use App\Models\Internship;
use Illuminate\Support\Facades\URL;
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
        // Auto-complete status PKL siswa yang tanggal selesainya sudah terlewati
        try {
            Internship::syncExpiredStatuses();
        } catch (\Throwable $e) {
            // Ignore if table doesn't exist during initial setup/migration
        }

        // Force HTTPS only in production environment or when behind an HTTPS reverse proxy.
        // Do NOT use APP_URL string matching — that causes redirect loops in local dev
        // when APP_URL is set to the production https:// URL.
        if (! $this->app->runningInConsole()) {
            if (
                $this->app->environment('production') ||
                request()->header('x-forwarded-proto') === 'https'
            ) {
                URL::forceScheme('https');
            }
        }
    }
}
