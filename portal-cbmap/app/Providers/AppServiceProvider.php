<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MinIOService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('minio', function () {
            return new MinIOService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
