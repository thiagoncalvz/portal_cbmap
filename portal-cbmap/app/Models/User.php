<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'contas.users';
    protected $fillable = [
        'keycloak_id',
        'name',
        'email',
        'password', // pode ficar null se não usar senha local
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Helpers de role
    public function rolesRealm(): array
    {
        return session('keycloak.roles.realm', []);
    }

    public function rolesClient(): array
    {
        return session('keycloak.roles.client', []);
    }

    public function hasRole(string $role, string $scope = 'any'): bool
    {
        $realm  = $this->rolesRealm();
        $client = $this->rolesClient();

        return match ($scope) {
            'realm'  => in_array($role, $realm, true),
            'client' => in_array($role, $client, true),
            default  => in_array($role, $realm, true) || in_array($role, $client, true),
        };
    }

    public function hasAnyRole(array $roles, string $scope = 'any'): bool
    {
        foreach ($roles as $r) if ($this->hasRole($r, $scope)) return true;
        return false;
    }
}
