<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Services\MinIOService;
use Illuminate\Pagination\Paginator;
use App\Models\Categorias;
use Illuminate\Support\Facades\View;

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
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('keycloak', \SocialiteProviders\Keycloak\Provider::class);
        });

        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            $view->with('categorias', Categorias::orderBy('nome')->get());
        });
    }
}
