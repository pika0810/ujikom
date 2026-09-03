<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\AlatController;

// public routes (tidak perlu token)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// protected routes (wajib membawa bearer token dari sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/log-aktivitas',[LogAktivitasController::class, 'index']);

    // hanya admin
    Route::middleware('role.admin')->group(function () {
        Route::apiResource('kategori', KategoriController::class);
        Route::apiResource('alat', AlatController::class);
        Route::get('/katalog',[AlatController::class, 'katalog']);
        //route untuk hak akses admin
    });
    Route::middleware('role.petugas')->group(function () {
        //route untuk hak akses petugas
    });
    Route::middleware('role.peminjam')->group(function () {
        Route::get('/katalog', [AlatController::class, 'katalog']);
        //route untuk hak akses peminjam
    });
});