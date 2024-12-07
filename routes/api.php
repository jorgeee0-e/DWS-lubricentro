<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MovimientoInventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rutas de la API organizadas por roles y con protecciones mediante middleware.
|
*/

// Ruta para obtener información del usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas públicas (sin protección)
Route::group([], function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
});

// Rutas protegidas con autenticación básica
Route::middleware('auth:sanctum')->group(function () {

    // Rutas para todos los usuarios autenticados
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
    Route::put('/user/{id}/update', [UsuarioController::class, 'updateUser']);

    // Rutas para roles específicos
    Route::middleware('role:superusuario')->group(function () {
        Route::patch('/user/{id}/deactivate', [UsuarioController::class, 'deactivateUser']);
        Route::get('/user/{id}', [UsuarioController::class, 'getUser']);
        Route::apiResource('/productos', ProductoController::class);
        Route::apiResource('/movimientos_inventario', MovimientoInventarioController::class);
        Route::apiResource('/ventas', VentaController::class);
    });

    Route::middleware('role:administrador_inventarios')->group(function () {
        Route::apiResource('/movimientos_inventario', MovimientoInventarioController::class)->only(['index', 'store', 'update']);
        Route::apiResource('/productos', ProductoController::class)->only(['index', 'store', 'update']);
    });

    Route::middleware('role:vendedor')->group(function () {
        Route::apiResource('/ventas', VentaController::class)->only(['index', 'store']);
    });
});
