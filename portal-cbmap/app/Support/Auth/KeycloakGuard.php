<?php

namespace App\Support\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class KeycloakGuard implements Guard
{
    protected ?Authenticatable $user = null;

    public function __construct(
        protected UserProvider $provider,
        protected Session $session,
        protected Request $request,
        protected string $sessionKey = 'auth_keycloak_id'
    ) {
        $this->user = null;
    }

    public function check()
    {
        return !is_null($this->user());
    }

    public function guest()
    {
        return !$this->check();
    }

    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $id = $this->session->get($this->sessionKey);
        if (!$id) return null;

        // Carrega via provider (Eloquent ou outro)
        return $this->user = $this->provider->retrieveById($id);
    }

    public function id()
    {
        return $this->user()?->getAuthIdentifier();
    }

    public function validate(array $credentials = [])
    {
        // Não usamos credenciais diretas (login/senha). Autenticação vem do Keycloak via Socialite.
        return false;
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
        $this->session->put($this->sessionKey, $user->getAuthIdentifier());
        $this->session->migrate(true);
        return $this;
    }

    // Helpers para login/logout usados pelo controller
    public function login(Authenticatable $user, bool $remember = false): void
    {
        $this->setUser($user);
        if ($remember && method_exists($user, 'getRememberToken')) {
            // use remember_token padrão do Laravel se quiser
        }
    }

    public function logout(): void
    {
        $this->session->remove($this->sessionKey);
        $this->session->forget('keycloak.roles.realm');
        $this->session->forget('keycloak.roles.client');
        $this->session->forget('keycloak.tokens');
        $this->user = null;
    }

    public function hasUser(): bool
    {
        return !is_null($this->user);
    }
}
