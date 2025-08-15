<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\OptionsController;

// ————— AUTHENTICACIÓN —————

// /api/auth/*
Route::prefix('auth')->group(function () {
    // público
    Route::post('login', [AutenticacionController::class, 'login']);

    // protegido por JWT
    Route::middleware('jwt.auth')->group(function () {
        Route::post('verificar-2fa',        [AutenticacionController::class, 'verificar2FA']);
        Route::post('logout',               [AutenticacionController::class, 'logout']);
        Route::get('obtenerUsuarioLogueado', [AutenticacionController::class, 'obtenerUsuarioLogueado']);
        Route::get('validar-token',        [AutenticacionController::class, 'obtenerSesionActualUsuario']);
        Route::post('refresh',              [AutenticacionController::class, 'refreshToken']);
    });
});

// /api/options/{table}
Route::get('options/{table}', [OptionsController::class, 'getOptions']);
