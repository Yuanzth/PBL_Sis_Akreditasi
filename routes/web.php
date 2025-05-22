<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ValidasiTahapSatuController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ValidasiKJMController;
use App\Http\Controllers\ValidasiDirController;
use Illuminate\Support\Facades\Route;

// Rute untuk tamu (pengguna yang belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/home', [WelcomeController::class, 'index'])->name('home');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'postlogin']);
});

// Rute untuk pengguna yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/validasitahapsatu', [ValidasiTahapSatuController::class, 'index']);  // menampilkan halaman awal user
    Route::post('/validasitahapsatu/list', [ValidasiTahapSatuController::class, 'list']);
});

// Rute untuk KJM
Route::middleware(['auth'])->group(function () {
    Route::get('/validasi-data', [ValidasiKJMController::class, 'index']);
    Route::get('/validasi-data/{id}/lihat', [ValidasiKJMController::class, 'show']);
    Route::put('/validasi-data/{id}/update', [ValidasiKJMController::class, 'updateStatus']);
});
// Rute untuk DIR
Route::middleware(['auth'])->group(function () {
    Route::get('/validasi-data', [ValidasiDirController::class, 'index']);
    Route::get('/validasi-data/{id}/lihat', [ValidasiDirController::class, 'show']);
    Route::put('/validasi-data/{id}/update', [ValidasiDirController::class, 'updateStatus']);
});
