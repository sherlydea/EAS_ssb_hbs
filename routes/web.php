<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\SiswaTurnamenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Semua route web untuk aplikasi SSB HBS, termasuk landing page, login,
| pendaftaran, dashboard siswa, jersey, SPP, absensi, dan turnamen.
|
*/

// Landing page (akses publik)
Route::get('/', [PublicController::class, 'index'])->name('home');

// Login & Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pendaftaran siswa
Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

// =======================
// Routes Siswa (authenticated)
// =======================
Route::middleware(['auth'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        // Dashboard utama
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

        // Profil siswa
        Route::get('/profil', [SiswaDashboardController::class, 'profil'])->name('profil');

        // Jadwal Latihan & Turnamen
        Route::get('/jadwal-latihan', [SiswaDashboardController::class, 'jadwalLatihan'])->name('jadwal-latihan');
        Route::get('/jadwal-turnamen', [SiswaDashboardController::class, 'jadwalTurnamen'])->name('jadwal-turnamen');

        // SPP Saya
        Route::get('/pembayaran', [SiswaDashboardController::class, 'pembayaran'])->name('pembayaran');
        Route::post('/pembayaran/upload', [SiswaDashboardController::class, 'uploadPembayaran'])->name('pembayaran.upload');
        Route::get('/riwayat-pembayaran', [SiswaDashboardController::class, 'riwayatPembayaran'])->name('riwayat-pembayaran');

        // Jersey Saya
        Route::get('/jersey', [SiswaDashboardController::class, 'jersey'])->name('jersey');
        Route::post('/jersey/pesan', [SiswaDashboardController::class, 'pesanJersey'])->name('jersey.pesan');
        Route::post('/jersey/upload/{id}', [SiswaDashboardController::class, 'uploadBuktiJersey'])->name('jersey.upload');

        // Absensi Saya
        Route::get('/riwayat-absensi', [SiswaDashboardController::class, 'riwayatAbsensi'])->name('riwayat-absensi');
    });

// =======================
// Placeholder Admin & Pelatih
// =======================
Route::middleware(['auth'])->get('/admin/dashboard', function () {
    return 'Dashboard Admin - bagian anggota 2';
})->name('admin.dashboard');

Route::middleware(['auth'])->get('/pelatih/dashboard', function () {
    return 'Dashboard Pelatih - bagian anggota 3';
})->name('pelatih.dashboard');

// =======================
// Turnamen siswa
// =======================
Route::get('/siswa/jadwal-turnamen', [SiswaTurnamenController::class, 'index'])
    ->name('siswa.jadwal-turnamen');

Route::post('/siswa/turnamen/upload/{id}', [SiswaTurnamenController::class, 'uploadBukti'])
    ->name('siswa.turnamen.upload');