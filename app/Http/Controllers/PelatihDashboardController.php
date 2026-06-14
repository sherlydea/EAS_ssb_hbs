<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PelatihDashboardController extends Controller
{
    public function index()
{
    // ======================
    // CEK ROLE PELATIH
    // ======================
    $user = auth()->user();

    if ($user->role !== 'pelatih') {
        abort(403, 'Akses hanya untuk pelatih');
    }

    // ======================
    // AMBIL DATA PELATIH
    // ======================
    $pelatih = DB::table('pelatihs')
    ->where('user_id', auth()->id())
    ->first();

    // ======================
    // MASTER DATA
    // ======================
    $totalSiswa = DB::table('siswas')->count();

    $totalLatihan = DB::table('jadwal_latihans')
        ->where('pelatih_id', $pelatih->id)
        ->count();

    // ======================
    // ABSENSI BULAN INI
    // ======================
    $totalAbsensi = DB::table('absensis')
        ->join('jadwal_latihans', 'absensis.jadwal_latihan_id', '=', 'jadwal_latihans.id')
        ->where('jadwal_latihans.pelatih_id', $pelatih->id)
        ->whereMonth('tanggal', now()->month)
        ->whereYear('tanggal', now()->year)
        ->count();

    $totalHadir = DB::table('absensis')
        ->join('jadwal_latihans', 'absensis.jadwal_latihan_id', '=', 'jadwal_latihans.id')
        ->where('jadwal_latihans.pelatih_id', $pelatih->id)
        ->where('status', 'Hadir')
        ->whereMonth('tanggal', now()->month)
        ->whereYear('tanggal', now()->year)
        ->count();

    $persentaseHadir = $totalAbsensi > 0
        ? round(($totalHadir / $totalAbsensi) * 100)
        : 0;

    // ======================
    // JADWAL PELATIH
    // ======================
    $jadwalMendatang = DB::table('jadwal_latihans')
    ->join('pelatihs', 'jadwal_latihans.pelatih_id', '=', 'pelatihs.id')
    ->join('users', 'pelatihs.user_id', '=', 'users.id')
    ->select(
        'jadwal_latihans.*',
        'users.name as nama_pelatih'
    )
    ->where('jadwal_latihans.pelatih_id', $pelatih->id) // ✔ INI BENAR
    ->orderBy('hari')
    ->get();

    // ======================
    // TURNAMEN
    // ======================
    $turnamenTerdekat = DB::table('turnamens')
        ->whereDate('tanggal', '>=', now())
        ->orderBy('tanggal')
        ->limit(3)
        ->get();

    // ======================
    // CHART ABSENSI
    // ======================
    $bulan = now()->month;
    $tahun = now()->year;
    $hariMax = now()->daysInMonth;

    $chartLabels = [];
    $chartData = [];

    for ($i = 1; $i <= $hariMax; $i += 5) {
        $end = min($i + 4, $hariMax);

        $total = DB::table('absensis')
            ->join('jadwal_latihans', 'absensis.jadwal_latihan_id', '=', 'jadwal_latihans.id')
            ->where('jadwal_latihans.pelatih_id', $pelatih->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->whereRaw("DAY(tanggal) BETWEEN $i AND $end")
            ->count();

        $hadir = DB::table('absensis')
            ->join('jadwal_latihans', 'absensis.jadwal_latihan_id', '=', 'jadwal_latihans.id')
            ->where('jadwal_latihans.pelatih_id', $pelatih->id)
            ->where('status', 'Hadir')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->whereRaw("DAY(tanggal) BETWEEN $i AND $end")
            ->count();

        $chartLabels[] = "$i-$end";
        $chartData[] = $total > 0 ? round(($hadir / $total) * 100) : 0;
    }

    // ======================
    // SESSION
    // ======================
    session([
        'dashboard_last_visit' => now()->format('Y-m-d H:i:s')
    ]);

    // ======================
    // RETURN VIEW (UI TIDAK DIUBAH)
    // ======================
    return view('pelatih.dashboard', compact(
        'totalSiswa',
        'totalLatihan',
        'totalAbsensi',
        'totalHadir',
        'persentaseHadir',
        'jadwalMendatang',
        'turnamenTerdekat',
        'chartLabels',
        'chartData'
    ));
 }
}