<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TagihanSpp;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Data Statistik Umum
        $totalSiswa = DB::table('siswas')->count();
        $totalPelatih = DB::table('pelatihs')->count();
        $totalJadwal = DB::table('jadwal_latihans')->count();
        
        // Statistik Tambahan
        $totalTagihan = TagihanSpp::count();
        $totalLunas = TagihanSpp::where('status', 'Lunas')->count();
        $totalBelumBayar = TagihanSpp::where('status', 'Belum Bayar')->count();

        // 2. Kalkulasi Pendapatan
        $totalPendapatan = DB::table('tagihan_spps')
            ->where('status', 'Lunas') 
            ->sum('nominal');

        // 3. Statistik Status Pembayaran untuk Chart
        $statusPembayaran = [
            TagihanSpp::where('status', 'Belum Bayar')->count(),
            TagihanSpp::where('status', 'Menunggu Verifikasi')->count(),
            TagihanSpp::where('status', 'Lunas')->count(),
            TagihanSpp::where('status', 'Ditolak')->count(),
        ];

        // 4. Data Pembayaran Terbaru (Hanya yang Lunas)
        $pembayaranTerbaru = TagihanSpp::with('siswa')
            ->where('status', 'Lunas')
            ->latest()
            ->take(5)
            ->get();

        // 5. Data Laporan Pembayaran (Per Bulan)
        $laporanPembayaran = DB::table('tagihan_spps')
            ->select(
                'bulan',
                DB::raw('COUNT(*) as jumlah'),
                DB::raw('SUM(nominal) as pendapatan')
            )
            ->where('status', 'Lunas')
            ->groupBy('bulan')
            ->get();

        // 6. Data Bar Chart (Pendapatan per bulan)
        $chartPembayaran = DB::table('tagihan_spps')
            ->select('bulan', DB::raw('SUM(nominal) as total'))
            ->where('status', 'Lunas')
            ->groupBy('bulan')
            ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
            ->get();

        // 7. Data Pie Chart (Persebaran Kategori Siswa)
        $chartKategori = DB::table('siswas')
            ->select('kategori_latihan', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori_latihan')
            ->get();

        return view('admin.report.index', compact(
            'totalSiswa', 'totalPelatih', 'totalJadwal', 'totalPendapatan', 
            'chartPembayaran', 'chartKategori', 'laporanPembayaran', 
            'statusPembayaran', 'pembayaranTerbaru',
            'totalTagihan', 'totalLunas', 'totalBelumBayar'
        ));
    }

    /**
     * Ekspor Laporan ke Excel
     */
    public function exportExcel()
    {
        return Excel::download(new ReportExport, 'laporan-ssb-hbs.xlsx');
    }

    /**
     * Ekspor Laporan ke PDF (Dengan data statistik lengkap)
     */
    public function exportPdf()
    {
        $totalSiswa = DB::table('siswas')->count();
        $totalPelatih = DB::table('pelatihs')->count();
        $totalJadwal = DB::table('jadwal_latihans')->count();
        $totalPendapatan = TagihanSpp::where('status', 'Lunas')->sum('nominal');

        $data = TagihanSpp::with('siswa')->latest()->get();

        $pdf = Pdf::loadView('admin.report.pdf', compact(
            'data', 'totalSiswa', 'totalPelatih', 'totalJadwal', 'totalPendapatan'
        ));

        return $pdf->download('laporan-ssb-hbs.pdf');
    }
}