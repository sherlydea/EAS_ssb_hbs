<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelatihReportController extends Controller
{
    public function index(Request $request)
    {
        $bulan    = $request->input('bulan', now()->month);
        $tahun    = $request->input('tahun', now()->year);
        $kategori = $request->input('kategori', '');

        // ── Rekap Absensi per Siswa ──
        $query = DB::table('siswas')
            ->where('status_verifikasi', 'Diterima')
            ->orderBy('nama');

        if ($kategori) {
            $query->where('kategori_latihan', $kategori);
        }

        $siswas = $query->get()->map(function ($s) use ($bulan, $tahun) {
            $base = DB::table('absensis')
                ->where('siswa_id', $s->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun);

            $total = (clone $base)->count();
            $hadir = (clone $base)->where('status', 'Hadir')->count();
            $izin  = (clone $base)->where('status', 'Izin')->count();
            $alpa  = (clone $base)->where('status', 'Alpa')->count();

            $s->total = $total;
            $s->hadir = $hadir;
            $s->izin  = $izin;
            $s->alpa  = $alpa;
            $s->pct   = $total > 0 ? round(($hadir / $total) * 100) : 0;
            return $s;
        });

        // Urutkan berdasarkan persentase kehadiran tertinggi (untuk ranking & bar chart)
        $siswasRanked = $siswas->sortByDesc('pct')->values();

        // ── Summary Cards ──
        $totalSiswa    = DB::table('siswas')->where('status_verifikasi', 'Diterima')->count();
        $totalAbsensi  = DB::table('absensis')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count();
        $totalHadir    = DB::table('absensis')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Hadir')->count();
        $totalIzin     = DB::table('absensis')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Izin')->count();
        $totalAlpa     = DB::table('absensis')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Alpa')->count();
        $rataKehadiran = $totalAbsensi > 0 ? round(($totalHadir / $totalAbsensi) * 100) : 0;

        // Jumlah sesi latihan unik (tanggal + jadwal) di bulan tsb
        $jumlahSesi = DB::table('absensis')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->select('tanggal', 'jadwal_latihan_id')
            ->distinct()
            ->count();

        // ── Trend Mingguan (4-5 minggu dalam bulan) ──
        $trendMingguan = DB::table('absensis')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->select(
                DB::raw('WEEK(tanggal, 1) as minggu_ke'),
                DB::raw("SUM(CASE WHEN status='Hadir' THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN status='Izin' THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN status='Alpa' THEN 1 ELSE 0 END) as alpa"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('minggu_ke')
            ->orderBy('minggu_ke')
            ->get()
            ->map(function ($row, $i) {
                $row->label = 'Minggu ' . ($i + 1);
                $row->pct   = $row->total > 0 ? round(($row->hadir / $row->total) * 100) : 0;
                return $row;
            });

        // ── Rekap Turnamen ──
        $turnamens = DB::table('peserta_turnamens')
            ->join('turnamens', 'peserta_turnamens.turnamen_id', '=', 'turnamens.id')
            ->select(
                'turnamens.nama_turnamen',
                'turnamens.tanggal',
                'turnamens.lokasi',
                'turnamens.status',
                DB::raw('COUNT(peserta_turnamens.siswa_id) as jumlah_peserta')
            )
            ->groupBy('turnamens.id', 'turnamens.nama_turnamen', 'turnamens.tanggal', 'turnamens.lokasi', 'turnamens.status')
            ->orderBy('turnamens.tanggal', 'desc')
            ->get();

        // ── Jadwal Latihan ──
        $jadwals = DB::table('jadwal_latihans')
            ->join('pelatihs', 'jadwal_latihans.pelatih_id', '=', 'pelatihs.id')
            ->select('jadwal_latihans.*', 'pelatihs.nama as nama_pelatih')
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->get();

        // ── Kategori List ──
        $kategoriList = DB::table('siswas')->distinct()->pluck('kategori_latihan');

        // ── Tahun List untuk filter ──
        $tahunList = range(now()->year, now()->year - 3);

        return view('pelatih.report', compact(
            'siswas', 'siswasRanked', 'totalSiswa', 'totalAbsensi', 'totalHadir',
            'totalIzin', 'totalAlpa', 'rataKehadiran', 'jumlahSesi', 'trendMingguan',
            'turnamens', 'jadwals', 'kategoriList',
            'bulan', 'tahun', 'tahunList', 'kategori'
        ));
    }

    public function export(Request $request)
{
    $type     = $request->input('type');
    $bulan    = $request->input('bulan', now()->month);
    $tahun    = $request->input('tahun', now()->year);
    $kategori = $request->input('kategori', '');

    $filename = $type . '_' . $bulan . '_' . $tahun . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

    if ($type === 'siswa') {
        $query = DB::table('siswas')->where('status_verifikasi', 'Diterima');
        if ($kategori) $query->where('kategori_latihan', $kategori);
        $data = $query->get();

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama', 'Kategori', 'No HP', 'Status']);
            foreach ($data as $row) {
                fputcsv($file, [$row->nama, $row->kategori_latihan, $row->no_hp ?? '-', $row->status_verifikasi]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    if ($type === 'absensi') {
        $query = DB::table('siswas')->where('status_verifikasi', 'Diterima');
        if ($kategori) $query->where('kategori_latihan', $kategori);
        $siswas = $query->get();

        $callback = function () use ($siswas, $bulan, $tahun) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama', 'Kategori', 'Hadir', 'Izin', 'Alpa', '% Hadir']);
            foreach ($siswas as $s) {
                $base  = DB::table('absensis')->where('siswa_id', $s->id)
                    ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
                $total = (clone $base)->count();
                $hadir = (clone $base)->where('status', 'Hadir')->count();
                $izin  = (clone $base)->where('status', 'Izin')->count();
                $alpa  = (clone $base)->where('status', 'Alpa')->count();
                $pct   = $total > 0 ? round(($hadir / $total) * 100) : 0;
                fputcsv($file, [$s->nama, $s->kategori_latihan, $hadir, $izin, $alpa, $pct . '%']);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    if ($type === 'turnamen') {
        $data = DB::table('peserta_turnamens')
            ->join('turnamens', 'peserta_turnamens.turnamen_id', '=', 'turnamens.id')
            ->join('siswas', 'peserta_turnamens.siswa_id', '=', 'siswas.id')
            ->select('turnamens.nama_turnamen', 'turnamens.tanggal', 'siswas.nama as nama_siswa', 'siswas.kategori_latihan')
            ->orderBy('turnamens.tanggal', 'desc')
            ->get();

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Turnamen', 'Tanggal', 'Nama Siswa', 'Kategori']);
            foreach ($data as $row) {
                fputcsv($file, [$row->nama_turnamen, \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y'), $row->nama_siswa, $row->kategori_latihan]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    abort(404);
    }
}