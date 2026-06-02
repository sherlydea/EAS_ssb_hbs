<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\SiswaDashboardController;

// Landing page
Route::get('/', [PublicController::class, 'index'])->name('home');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pendaftaran siswa
Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

// Dashboard siswa dan fitur siswa
Route::middleware(['auth'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [SiswaDashboardController::class, 'profil'])->name('profil');
        Route::get('/jadwal-latihan', [SiswaDashboardController::class, 'jadwalLatihan'])->name('jadwal-latihan');
        Route::get('/jadwal-turnamen', [SiswaDashboardController::class, 'jadwalTurnamen'])->name('jadwal-turnamen');
        Route::get('/pembayaran', [SiswaDashboardController::class, 'pembayaran'])->name('pembayaran');
Route::post('/pembayaran/upload', [SiswaDashboardController::class, 'uploadPembayaran'])->name('pembayaran.upload');
Route::get('/riwayat-pembayaran', [SiswaDashboardController::class, 'riwayatPembayaran'])->name('riwayat-pembayaran');
        Route::get('/jersey', [SiswaDashboardController::class, 'jersey'])->name('jersey');
Route::post('/jersey/pesan', [SiswaDashboardController::class, 'pesanJersey'])->name('jersey.pesan');
        Route::get('/riwayat-absensi', [SiswaDashboardController::class, 'riwayatAbsensi'])->name('riwayat-absensi');
    });

// Placeholder admin
Route::middleware(['auth'])->get('/admin/dashboard', function () {
    return 'Dashboard Admin - bagian anggota 2';
})->name('admin.dashboard');

// Placeholder pelatih
Route::middleware(['auth'])->get('/pelatih/dashboard', function () {
    return 'Dashboard Pelatih - bagian anggota 3';
})->name('pelatih.dashboard');