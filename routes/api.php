<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MovimientoInventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UsuarioController;
use App\Models\User;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // Obtener el usuario autenticado
    $user = Auth::user();

    if ($user->role === 'superusuario') {
        return User::where('status',1)->get(); // Devuelve todos los usuarios
    }
    return $request->user();
});

//Register new user
Route::post('/register',[RegisterController::class, 'register']);

//Login
Route::post('/login',[LoginController::class, 'login']);
//Logout 
Route::post('/logout', [LoginController::class, 'logout']);
//Not auth users
Route::get('/login', function () {
    return response()->json(['message' => 'Please log in'], 401);
})->name('login');

//Rutas para productos y movimientos
Route::apiResource('productos', ProductoController::class);
Route::apiResource('movimientos_inventario', MovimientoInventarioController::class);
Route::apiResource('ventas', VentaController::class);

//Desactivar Usuarios
Route::patch('user/{id}/deactivate', [UsuarioController::class, 'deactivateUser']);
//Get un solo usuario
Route::get('user/{id}', [UsuarioController::class, 'getUser']);
//ResetPassword
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
//actualziar usuario
Route::put('/user/{id}/update', [UsuarioController::class, 'updateUser']);

