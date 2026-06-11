<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan halaman ringkasan (dashboard) utama panel admin.
     */
    public function index()
    {
        // 1. Mengambil data agregasi (Counter) untuk komponen widget statistik
        $totalSiswa = DB::table('siswas')->count();

        $totalPelatih = DB::table('pelatihs')->count();

        $totalTurnamen = DB::table('turnamens')->count();

        $totalPembayaran = DB::table('pembayarans')->count();

        $totalPendaftaranPending = DB::table('pendaftarans')
            ->where('status', 'pending')
            ->count();

        $totalSPPMenunggu = DB::table('tagihan_spps')
            ->where('status', 'Menunggu Verifikasi')
            ->count();

        // 2. Perbaikan Query Pendaftaran Terbaru: Memastikan id terseleksi untuk kebutuhan rute detail
        $pendaftaranTerbaru = DB::table('pendaftarans')
            ->select(
                'pendaftarans.id',
                'pendaftarans.nama',
                'pendaftarans.kategori_latihan',
                'pendaftarans.status'
            )
            ->orderBy('pendaftarans.created_at', 'desc')
            ->limit(5)
            ->get();

        // 3. Perbaikan Query Pembayaran Terbaru: Menyisipkan id milik tabel pembayarans agar tidak null saat diklik
        $pembayaranTerbaru = DB::table('pembayarans')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->select(
                'pembayarans.id',
                'siswas.nama',
                'pembayarans.jumlah',
                'pembayarans.status'
            )
            ->latest('pembayarans.created_at')
            ->take(5)
            ->get();

        // 4. Mengambil data statistik untuk komponen Chart JS grafik
        $siswaPerKategori = DB::table('siswas')
            ->select('kategori_latihan', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori_latihan')
            ->orderBy('kategori_latihan')
            ->get();

        $statusPendaftaran = DB::table('pendaftarans')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        // 5. Lempar semua variabel ke view admin dashboard
        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalPelatih',
            'totalTurnamen',
            'totalPembayaran',
            'totalPendaftaranPending',
            'totalSPPMenunggu',
            'pendaftaranTerbaru',
            'pembayaranTerbaru',
            'siswaPerKategori',
            'statusPendaftaran'
        ));
    }
}