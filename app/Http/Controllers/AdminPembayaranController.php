<?php

namespace App\Http\Controllers;

use App\Models\TagihanSpp;
use Illuminate\Http\Request;

class AdminPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = TagihanSpp::with('siswa');

        if ($request->search) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        $tagihans = $query
            ->latest()
            ->paginate(10);

        $totalTagihan = TagihanSpp::count();

        $belumBayar = TagihanSpp::where('status', 'Belum Bayar')->count();

        $menunggu = TagihanSpp::where(
            'status',
            'Menunggu Verifikasi'
        )->count();

        $lunas = TagihanSpp::where(
            'status',
            'Lunas'
        )->count();

        $ditolak = TagihanSpp::where(
            'status',
            'Ditolak'
        )->count();

        // Grafik Status Pembayaran

        $chartStatus = [
            $belumBayar,
            $menunggu,
            $lunas,
            $ditolak
        ];

        // Grafik Pendapatan Bulanan

        $pendapatanBulanan = TagihanSpp::where('status', 'Lunas')
        ->whereNotNull('tanggal_bayar')
        ->selectRaw('MONTH(tanggal_bayar) as bulan')
        ->selectRaw('SUM(nominal) as total')
        ->groupByRaw('MONTH(tanggal_bayar)')
        ->orderByRaw('MONTH(tanggal_bayar)')
        ->get();

        $labelsPendapatan = ['Jan','Feb','Mar','Apr','Mei','Jun'];

        $dataPendapatan = [
            0,
            0,
            0,
            0,
            150000,
            0
        ];
        foreach ($pendapatanBulanan as $item) {
            $labelsPendapatan[] = date('M', mktime(0,0,0,$item->bulan,1));
            $dataPendapatan[] = $item->total;
        }

        return view(
            'admin.pembayaran.index',
            compact(
                'tagihans',
                'totalTagihan',
                'belumBayar',
                'menunggu',
                'lunas',
                'ditolak',
                'chartStatus',
                'labelsPendapatan',
                'dataPendapatan'
            )
        );
    }

    public function show($id)
    {
        $tagihan = TagihanSpp::with('siswa')
            ->findOrFail($id);

        return view(
            'admin.pembayaran.show',
            compact('tagihan')
        );
    }

    public function terima(Request $request, $id)
    {
        $tagihan = TagihanSpp::findOrFail($id);

        $tagihan->update([
            'status' => 'Lunas',
            'catatan_admin' => null,
        ]);

        return redirect()
            ->route('admin.pembayaran.show', $id)
            ->with(
                'success',
                'Pembayaran berhasil diverifikasi.'
            );
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:1000'
        ]);

        $tagihan = TagihanSpp::findOrFail($id);

        $tagihan->update([
            'status' => 'Ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()
            ->route('admin.pembayaran.show', $id)
            ->with(
                'success',
                'Pembayaran berhasil ditolak.'
            );
    }
}