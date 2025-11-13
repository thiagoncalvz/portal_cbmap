<?php

use App\Http\Controllers\RegulamentosController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\Autenticador;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use LdapRecord\Models\OpenLDAP\User as LdapUser;

use LdapRecord\Container;
use LdapRecord\Models\OpenLDAP\User;

Route::get('/', function () {
    return redirect('/regulamentos');
})->middleware(Autenticador::class);

Route::resource('/regulamentos', RegulamentosController::class)
    ->except(['show']);

Route::get('/regulamentos/download/{regulamento}', [RegulamentosController::class, 'DownloadRegulamento'])
    ->name('regulamentos.download');

Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->name('sain');

Route::middleware('auth')->group(function () {
    Route::get('/', fn() => redirect('/regulamentos'));
    Route::resource('/regulamentos', RegulamentosController::class)->except('show');
    Route::get('/regulamentos/download/{regulamento}', [RegulamentosController::class,'DownloadRegulamento'])
        ->name('regulamentos.download');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});

// routes/web.php (temporário, remova depois)
// Route::get('/ldap-test/{cpf}', function ($cpf) {
//     $user = LdapRecord\Models\OpenLDAP\User::whereEquals('uid', $cpf)->first();

//     if (!$user) return 'Usuário não encontrado no LDAP.';

//     return [
//         'dn' => $user->getDn(),
//         'cn' => $user->getFirstAttribute('cn'),
//         'mail' => $user->getFirstAttribute('mail'),
//         'uid' => $user->getFirstAttribute('uid'),
//     ];
// });



Route::get('/ldap-test/{cpf}', function (string $cpf) {
  try {
    $cpf = preg_replace('/\D/', '', $cpf);
    $user = LdapUser::whereEquals('uid', $cpf)->first();

    if (!$user) {
      return response()->json(['ok' => false, 'msg' => 'Usuário não encontrado no LDAP', 'cpf' => $cpf], 404);
    }

    return response()->json([
      'ok'   => true,
      'dn'   => $user->getDn(),
      'cn'   => $user->getFirstAttribute('cn'),
      'mail' => $user->getFirstAttribute('mail'),
      'uid'  => $user->getFirstAttribute('uid'),
    ]);
  } catch (\Throwable $e) {
    Log::error('LDAP TEST ERROR', ['e' => $e]);
    return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
  }
});



Route::get('/ldap-bind-test', function () {
    try {
        $connection = Container::getDefaultConnection();
        $success = $connection->auth()->attempt(
            'uid=02838328271,cn=self registered users,dc=cbm,dc=ap,dc=gov,dc=br',
            'Thi7a#go'
        );

        return response()->json([
            'connected' => $success,
            'message' => $success ? '✅ Autenticado com sucesso!' : '❌ Falha na autenticação.',
        ]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});
