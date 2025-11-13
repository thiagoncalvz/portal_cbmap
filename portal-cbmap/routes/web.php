<?php

use App\Http\Controllers\RegulamentosController;
use App\Http\Controllers\Auth\KeycloakController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/regulamentos');
})->name('dashboard');

    Route::resource('/regulamentos', RegulamentosController::class)
    ->only(['index']);

Route::middleware(['auth:keycloak'])->group(function () {
    Route::resource('/regulamentos', RegulamentosController::class)
    ->only(['create', 'store', 'destroy', 'edit', 'update']);
});

Route::get('/regulamentos/download/{regulamento}', [RegulamentosController::class, 'DownloadRegulamento'])
    ->name('regulamentos.download');

Route::get('login', [KeycloakController::class, 'redirect'])->name('login');
Route::get('callback', [KeycloakController::class, 'callback'])->name('callback');

Route::post('/logout', function () {
    // Sai do guard local
    Auth::guard('keycloak')->logout();

    // Opcional: redirecionar para logout do Keycloak (end_session_endpoint)
    $base   = rtrim(config('services.keycloak.base_url'), '/');
    $realm  = config('services.keycloak.realms');
    $client = config('services.keycloak.client_id');
    $redir  = urlencode(config('app.url'));

    $kcLogout = "{$base}/realms/{$realm}/protocol/openid-connect/logout?client_id={$client}&post_logout_redirect_uri={$redir}";
    return redirect()->away($kcLogout);
})->name('logout')->middleware('auth:keycloak');