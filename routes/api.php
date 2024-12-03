<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MovimientoInventarioController;
use App\Http\Controllers\ProductoController;

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
