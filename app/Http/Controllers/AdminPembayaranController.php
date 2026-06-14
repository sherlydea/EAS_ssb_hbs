<?php

namespace App\Http\Controllers;

use App\Models\TagihanSpp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $menunggu = TagihanSpp::where('status', 'Menunggu Verifikasi')->count();
        $lunas = TagihanSpp::where('status', 'Lunas')->count();
        $ditolak = TagihanSpp::where('status', 'Ditolak')->count();

        // Grafik Status Pembayaran
        $chartStatus = [$belumBayar, $menunggu, $lunas, $ditolak];

        // Grafik Pendapatan Bulanan
        $pendapatanBulanan = TagihanSpp::where('status', 'Lunas')
            ->whereNotNull('tanggal_bayar')
            ->selectRaw('MONTH(tanggal_bayar) as bulan')
            ->selectRaw('SUM(nominal) as total')
            ->groupByRaw('MONTH(tanggal_bayar)')
            ->orderByRaw('MONTH(tanggal_bayar)')
            ->get();

        $labelsPendapatan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
        $dataPendapatan = [0, 0, 0, 0, 150000, 0];
        
        foreach ($pendapatanBulanan as $item) {
            $labelsPendapatan[] = date('M', mktime(0, 0, 0, $item->bulan, 1));
            $dataPendapatan[] = $item->total;
        }

        return view('admin.pembayaran.index', compact(
            'tagihans', 'totalTagihan', 'belumBayar', 'menunggu', 
            'lunas', 'ditolak', 'chartStatus', 'labelsPendapatan', 'dataPendapatan'
        ));
    }

    public function create()
    {
        // Mengambil semua siswa yang statusnya diterima
        $siswas = DB::table('siswas')->where('status_verifikasi', 'Diterima')->get();
        return view('admin.pembayaran.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'nominal' => 'required|numeric',
            'bulan' => 'required',
            'tahun' => 'required|numeric',
        ]);

        // Cek duplikat agar tidak ada tagihan ganda untuk bulan yang sama
        $exists = TagihanSpp::where('siswa_id', $request->siswa_id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Tagihan untuk siswa ini pada periode tersebut sudah ada!');
        }

        TagihanSpp::create([
            'siswa_id' => $request->siswa_id,
            'nominal' => $request->nominal,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'status' => 'Belum Bayar',
        ]);

        return redirect()->route('admin.pembayaran.index')->with('success', 'Tagihan berhasil dibuat!');
    }

    public function show($id)
    {
        $tagihan = TagihanSpp::with('siswa')->findOrFail($id);
        return view('admin.pembayaran.show', compact('tagihan'));
    }

    public function terima($id)
    {
        $tagihan = TagihanSpp::findOrFail($id);
        $tagihan->update([
            'status' => 'Lunas',
            'catatan_admin' => null,
        ]);

        return redirect()->route('admin.pembayaran.show', $id)
            ->with('success', 'Pembayaran berhasil diverifikasi.');
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

        return redirect()->route('admin.pembayaran.show', $id)
            ->with('success', 'Pembayaran berhasil ditolak.');
    }
}