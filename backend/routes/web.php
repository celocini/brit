<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\D4SignController;
 
Route::controller(D4SignController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/gera_documento', 'documento');
    //Route::post('/orders', 'store');
});
