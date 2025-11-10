<?php

use App\Http\Controllers\RegulamentosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/regulamentos');
});
Route::resource('/regulamentos', RegulamentosController::class)
    ->except(['show']);