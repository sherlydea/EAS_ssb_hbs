<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\SiswaTurnamenController;
use App\Http\Controllers\AdminPendaftaranController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminPembayaranController;
use App\Http\Controllers\JadwalLatihanController;
use App\Http\Controllers\PelatihController;
use App\Http\Controllers\AdminTurnamenController;
use App\Http\Controllers\AdminPesertaTurnamenController;
use App\Http\Controllers\AdminJerseyController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES - SSB HBS
|--------------------------------------------------------------------------
*/

/* --- HALAMAN PUBLIK --- */
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* --- PENDAFTARAN SISWA --- */
Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

/* --- DASHBOARD SISWA --- */
Route::middleware(['auth'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [SiswaDashboardController::class, 'profil'])->name('profil');
    Route::get('/jadwal-latihan', [SiswaDashboardController::class, 'jadwalLatihan'])->name('jadwal-latihan');
    Route::get('/pembayaran', [SiswaDashboardController::class, 'pembayaran'])->name('pembayaran');
    Route::post('/pembayaran/upload', [SiswaDashboardController::class, 'uploadPembayaran'])->name('pembayaran.upload');
    Route::get('/riwayat-pembayaran', [SiswaDashboardController::class, 'riwayatPembayaran'])->name('riwayat-pembayaran');
    Route::get('/jersey', [SiswaDashboardController::class, 'jersey'])->name('jersey');
    Route::post('/jersey/pesan', [SiswaDashboardController::class, 'pesanJersey'])->name('jersey.pesan');
    Route::post('/jersey/upload/{id}', [SiswaDashboardController::class, 'uploadBuktiJersey'])->name('jersey.upload');
    Route::get('/riwayat-absensi', [SiswaDashboardController::class, 'riwayatAbsensi'])->name('riwayat-absensi');
});

/* --- ADMIN --- */
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Pendaftaran
    Route::get('/pendaftaran', [AdminPendaftaranController::class, 'index'])->name('pendaftaran');
    Route::get('/pendaftaran/{id}', [AdminPendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::post('/pendaftaran/{id}/terima', [AdminPendaftaranController::class, 'terima'])->name('pendaftaran.terima');
    Route::post('/pendaftaran/{id}/tolak', [AdminPendaftaranController::class, 'tolak'])->name('pendaftaran.tolak');

    // Pembayaran SPP
    Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/{id}', [AdminPembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{id}/terima', [AdminPembayaranController::class, 'terima'])->name('pembayaran.terima');
    Route::post('/pembayaran/{id}/tolak', [AdminPembayaranController::class, 'tolak'])->name('pembayaran.tolak');

    // Jadwal Latihan
    Route::get('/jadwal-latihan', [JadwalLatihanController::class, 'index'])->name('jadwal-latihan.index');
    Route::get('/jadwal-latihan/create', [JadwalLatihanController::class, 'create'])->name('jadwal-latihan.create');
    Route::post('/jadwal-latihan', [JadwalLatihanController::class, 'store'])->name('jadwal-latihan.store');
    Route::get('/jadwal-latihan/{id}/edit', [JadwalLatihanController::class, 'edit'])->name('jadwal-latihan.edit');
    Route::put('/jadwal-latihan/{id}', [JadwalLatihanController::class, 'update'])->name('jadwal-latihan.update');
    Route::delete('/jadwal-latihan/{id}', [JadwalLatihanController::class, 'destroy'])->name('jadwal-latihan.destroy');

    // Data Pelatih
    Route::get('/pelatih', [PelatihController::class, 'index'])->name('pelatih.index');
    Route::get('/pelatih/create', [PelatihController::class, 'create'])->name('pelatih.create');
    Route::post('/pelatih', [PelatihController::class, 'store'])->name('pelatih.store');
    Route::get('/pelatih/{id}/edit', [PelatihController::class, 'edit'])->name('pelatih.edit');
    Route::put('/pelatih/{id}', [PelatihController::class, 'update'])->name('pelatih.update');
    Route::delete('/pelatih/{id}', [PelatihController::class, 'destroy'])->name('pelatih.destroy');

    // Turnamen
    Route::get('/turnamen', [AdminTurnamenController::class, 'index'])->name('turnamen.index');
    Route::get('/turnamen/create', [AdminTurnamenController::class, 'create'])->name('turnamen.create');
    Route::post('/turnamen', [AdminTurnamenController::class, 'store'])->name('turnamen.store');
    Route::get('/turnamen/{id}/edit', [AdminTurnamenController::class, 'edit'])->name('turnamen.edit');
    Route::put('/turnamen/{id}', [AdminTurnamenController::class, 'update'])->name('turnamen.update');
    Route::delete('/turnamen/{id}', [AdminTurnamenController::class, 'destroy'])->name('turnamen.destroy');

    // Peserta Turnamen
    Route::get('/peserta-turnamen', [AdminPesertaTurnamenController::class, 'index'])->name('peserta-turnamen.index');
    Route::get('/peserta-turnamen/create', [AdminPesertaTurnamenController::class, 'create'])->name('peserta-turnamen.create');
    Route::post('/peserta-turnamen', [AdminPesertaTurnamenController::class, 'store'])->name('peserta-turnamen.store');
    Route::get('/peserta-turnamen/{id}/edit', [AdminPesertaTurnamenController::class, 'edit'])->name('peserta-turnamen.edit');
    Route::put('/peserta-turnamen/{id}', [AdminPesertaTurnamenController::class, 'update'])->name('peserta-turnamen.update');
    Route::delete('/peserta-turnamen/{id}', [AdminPesertaTurnamenController::class, 'destroy'])->name('peserta-turnamen.destroy');
    Route::post('/peserta-turnamen/{id}/terima', [AdminPesertaTurnamenController::class, 'terima'])->name('peserta-turnamen.terima');
    Route::post('/peserta-turnamen/{id}/tolak', [AdminPesertaTurnamenController::class, 'tolak'])->name('peserta-turnamen.tolak');
    Route::post('/peserta-turnamen/{id}/konfirmasi', [AdminPesertaTurnamenController::class, 'konfirmasi'])->name('peserta-turnamen.konfirmasi');

    // Jersey
    Route::get('/jersey', [AdminJerseyController::class, 'index'])->name('jersey.index');
    Route::post('/jersey/{id}/terima', [AdminJerseyController::class, 'terima'])->name('jersey.terima');
    Route::post('/jersey/{id}/tolak', [AdminJerseyController::class, 'tolak'])->name('jersey.tolak');
    Route::post('/jersey/{id}/selesai', [AdminJerseyController::class, 'selesai'])->name('jersey.selesai');

    // Laporan & Export
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/pdf', [ReportController::class, 'exportPdf'])->name('report.pdf');
    Route::get('/report/excel', [ReportController::class, 'exportExcel'])->name('report.excel');

    // Data Siswa
    Route::get('/siswas', [SiswaController::class, 'index'])->name('siswas.index');
    Route::get('/siswas/{id}', [SiswaController::class, 'show'])->name('siswas.show');
    Route::get('/siswas/{id}/edit', [SiswaController::class, 'edit'])->name('siswas.edit');
    Route::put('/siswas/{id}', [SiswaController::class, 'update'])->name('siswas.update');
    Route::delete('/siswas/{id}', [SiswaController::class, 'destroy'])->name('siswas.destroy');
});

/* --- PELATIH & SISWA TURNAMEN (Global Rute) --- */
Route::middleware(['auth'])->group(function () {
    Route::get('/pelatih/dashboard', function () { return 'Dashboard Pelatih'; })->name('pelatih.dashboard');
    Route::get('/siswa/jadwal-turnamen', [SiswaTurnamenController::class, 'index'])->name('siswa.jadwal-turnamen');
    Route::post('/siswa/turnamen/upload/{id}', [SiswaTurnamenController::class, 'uploadBukti'])->name('siswa.turnamen.upload');
});