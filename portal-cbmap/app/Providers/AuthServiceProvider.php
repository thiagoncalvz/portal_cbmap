<?php

namespace App\Providers;

use App\Support\Auth\KeycloakGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // \App\Models\Post::class => \App\Policies\PostPolicy::class,
    ];

    public function boot(): void
    {
        // Driver do guard "keycloak"
        Auth::extend('keycloak', function ($app, $name, array $config) {
            $provider = Auth::createUserProvider($config['provider'] ?? null);
            $session  = $app['session.store'];
            $request  = $app['request'];

            return new KeycloakGuard($provider, $session, $request);
        });

        // Gate global opcional: super-admin bypass
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        // Exemplos de gates por role
        Gate::define('manage-users', fn($user) => $user->hasAnyRole(['admin', 'user-manager']));
        Gate::define('publish-post', fn($user) => $user->hasRole('publisher', 'client')); // escopo client
    }
}
