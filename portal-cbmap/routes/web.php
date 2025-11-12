<?php

use App\Http\Controllers\RegulamentosController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\Autenticador;
use Illuminate\Support\Facades\Route;

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