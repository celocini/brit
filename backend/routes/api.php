<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\D4SignController;

//Route::get('documento', [D4SignController::class, 'index']);
Route::post('documento', [D4SignController::class, 'documento']);
Route::post('documento_webhook', [D4SignController::class, 'documento_webhook']);
