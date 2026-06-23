<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Application;
use App\Policies\ApplicationPolicy;

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
        // Register Application policy
        \Gate::policy(Application::class, ApplicationPolicy::class);
    }
}
