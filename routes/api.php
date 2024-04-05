<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ImageVerifikasiController;
use App\Http\Controllers\JajananController;
use App\Http\Controllers\LanggananController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OtpController;
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

Route::post('/otp', [OtpController::class, 'sendOtp']);

Route::prefix('/users')->group(function () {
    Route::post('/register-customer', [UserController::class, 'registerCustomer']);
    Route::post('/login-customer', [UserController::class, 'loginCustomer']);
    Route::post('/register-pedagang', [UserController::class, 'registerPedagang']);
    Route::post('/login-pedagang', [UserController::class, 'loginPedagang']);

    Route::get('/show', [UserController::class, 'show'])->middleware('auth:sanctum');
    Route::put('/update', [UserController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
    Route::put('/location', [UserController::class, 'updateLocation'])->middleware('auth:sanctum');
    Route::post('/update-profile-picture', [UserController::class, 'updateProfilePicture'])->middleware('auth:sanctum');
});

Route::prefix('/pedagang')->group(function () {
    Route::post('/store', [PedagangController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/update', [PedagangController::class, 'update'])->middleware('auth:sanctum');
    Route::put('/update-status', [PedagangController::class, 'updateStatus'])->middleware('auth:sanctum');
    Route::get('/show-current', [PedagangController::class, 'showCurrent'])->middleware('auth:sanctum');
    Route::get('/show/{id}', [PedagangController::class, 'showById'])->middleware('auth:sanctum');
    Route::get('/show-all', [PedagangController::class, 'showAll'])->middleware('auth:sanctum');
    Route::post('/update-sertifikat', [PedagangController::class, 'updateSertifikat'])->middleware('auth:sanctum');

    Route::put('/{id}/update-sertifikasi-admin', [PedagangController::class, 'updateSertifikasiByAdmin']);

    Route::post('/{pedagangId}/jajanan', [JajananController::class, 'store'])->middleware('auth:sanctum');
    Route::put('/{pedagangId}/jajanan/{jajananId}', [JajananController::class, 'update'])->middleware('auth:sanctum');
    Route::put('/{pedagangId}/jajanan-tersedia/{jajananId}', [JajananController::class, 'updateTersedia'])->middleware('auth:sanctum');
    Route::delete('/{pedagangId}/jajanan/{jajananId}', [JajananController::class, 'delete'])->middleware('auth:sanctum');

    Route::post('/{pedagangId}/jajanan/{jajananId}/cart', [CartController::class, 'store'])->middleware('auth:sanctum');
    Route::put('/{pedagangId}/jajanan/{jajananId}/cart/{cartId}', [CartController::class, 'update'])->middleware('auth:sanctum');
    Route::get('/{pedagangId}/jajanan/{jajananId}/cart/show-current', [CartController::class, 'showCurrent'])->middleware('auth:sanctum');
});

Route::prefix('/image-verifikasi')->group(function () {
    Route::post('/store', [ImageVerifikasiController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/show-all', [ImageVerifikasiController::class, 'showAll']);
    Route::put('/delete', [ImageVerifikasiController::class, 'delete']);
});

Route::prefix('/order')->group(function () {
    Route::post('/store/{pedagangId}/{cartId}', [OrderController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/show-current', [OrderController::class, 'showCurrent'])->middleware('auth:sanctum');
    Route::get('/show-pedagang/{pedagangId}', [OrderController::class, 'showByPedagangId'])->middleware('auth:sanctum');
});

Route::prefix('/langganan')->group(function () {
    Route::post('/store', [LanggananController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/show-current', [LanggananController::class, 'showCurrent'])->middleware('auth:sanctum');
    Route::delete('/delete/{pedagangId}', [LanggananController::class, 'delete'])->middleware('auth:sanctum');
});