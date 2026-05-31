<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\SiswaDashboardController;

/*
|--------------------------------------------------------------------------
| ROUTE ANGGOTA 1 - PUBLIC PAGE, AUTH, PENDAFTARAN, SISWA
|--------------------------------------------------------------------------
*/

// Halaman utama / landing page
Route::get('/', [PublicController::class, 'index'])->name('home');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pendaftaran siswa
Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

// Dashboard siswa (hanya bisa diakses jika login sebagai siswa)
Route::middleware(['auth'])->group(function() {
    Route::get('/siswa/dashboard', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard');
});