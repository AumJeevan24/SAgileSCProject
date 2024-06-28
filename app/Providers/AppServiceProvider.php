<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('production')) {
            $this->app->register(DebugbarServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);

        // Ensure /tmp/bootstrap/cache directory exists and is writable
        $cachePath = '/tmp/bootstrap/cache';
        if (!File::exists($cachePath)) {
            File::makeDirectory($cachePath, 0755, true);
        }

        $this->app->useStoragePath(env('APP_STORAGE', base_path() . '/storage'));
        $this->app->bind('path.cache', function() use ($cachePath) {
            return $cachePath;
        });

        // User::observe(Notifier::class);
    }
}
