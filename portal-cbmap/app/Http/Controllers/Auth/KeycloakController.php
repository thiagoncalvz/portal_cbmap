<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class KeycloakController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('keycloak')->scopes(['openid', 'profile', 'email'])->redirect();
    }

    public function callback()
    {
        $socialiteUser = Socialite::driver('keycloak')->user();

        // Dados básicos
        $keycloakId   = $socialiteUser->getId();      // 'sub' do OpenID
        $name         = $socialiteUser->getName();
        $email        = $socialiteUser->getEmail();

        // Opcional: persistir/atualizar usuário local (para seu uso interno)
        $user = User::updateOrCreate(
            ['keycloak_id' => $keycloakId],
            ['name' => $name ?? $email, 'email' => $email]
        );

        // Tokens e claims para extrair roles
        $accessToken  = $socialiteUser->token; // JWT access_token
        $idToken      = $socialiteUser->accessTokenResponseBody['id_token'] ?? null;

        // Parse de roles do token (realm e client)
        [$realmRoles, $clientRoles] = $this->extractRolesFromTokens(
            $accessToken,
            $idToken,
            config('services.keycloak.client_id')
        );

        // Guard customizado faz o login e armazena user + roles em sessão
        Auth::guard('keycloak')->login($user, remember: true);
        // Sincroniza roles na sessão do guard
        session([
            'keycloak.roles.realm'   => $realmRoles,
            'keycloak.roles.client'  => $clientRoles,
            'keycloak.tokens' => [
                'access_token' => $accessToken,
                'id_token'     => $idToken,
                'refresh_token'=> $socialiteUser->refreshToken ?? null,
                'expires_in'   => $socialiteUser->expiresIn ?? null,
            ],
        ]);

        return redirect()->intended(route('dashboard'));
    }

    private function extractRolesFromTokens(?string $accessToken, ?string $idToken, string $clientId): array
    {
        $claims = [];
        foreach ([$accessToken, $idToken] as $jwt) {
            if (!$jwt) continue;
            $parts = explode('.', $jwt);
            if (count($parts) < 2) continue;
            $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
            if (is_array($payload)) {
                $claims = array_replace_recursive($claims, $payload);
            }
        }

        $realmRoles = $claims['realm_access']['roles'] ?? [];
        $clientRoles = $claims['resource_access'][$clientId]['roles'] ?? [];

        return [array_values(array_unique($realmRoles)), array_values(array_unique($clientRoles))];
    }
}