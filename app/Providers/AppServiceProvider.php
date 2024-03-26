<?php

namespace App\Providers;

use App\Services\ThemeConfig;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use app\Http\Team;
use app\Observers\Notifier;
use app\Http\User;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ThemeConfig::class, function ($app) {
            return new ThemeConfig();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // User::observe(Notifier::class);
    }
}
