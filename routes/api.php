<?php

use App\Http\Controllers\PedagangController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/users')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/register-customer', [UserController::class, 'registerCustomer']);
    Route::post('/login-customer', [UserController::class, 'loginCustomer']);
    Route::post('/register-pedagang', [UserController::class, 'registerPedagang']);
    Route::post('/login-pedagang', [UserController::class, 'loginPedagang']);

    Route::get('/show', [UserController::class, 'show'])->middleware('auth:sanctum');
    Route::put('/edit', [UserController::class, 'edit'])->middleware('auth:sanctum');
    Route::delete('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
});

Route::prefix('/pedagang')->group(function () {
    Route::post('/store', [PedagangController::class, 'store'])->middleware('auth:sanctum');
    Route::put('/update', [PedagangController::class, 'update'])->middleware('auth:sanctum');
    Route::put('/update-buka', [PedagangController::class, 'updateBuka'])->middleware('auth:sanctum');
    Route::get('/show', [PedagangController::class, 'show'])->middleware('auth:sanctum');
    Route::delete('/delete', [PedagangController::class, 'delete'])->middleware('auth:sanctum');

    Route::put('/update-sertifikasi', [PedagangController::class, 'updateSertifikasi']);
});
