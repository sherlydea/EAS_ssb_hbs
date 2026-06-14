<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa dengan perbaikan pengelompokan logika query (Search & Filter).
     */
    public function index(Request $request)
    {
        // =========================
        // Data Siswa + Search + Filter (Logical Grouping Fixed)
        // =========================
        $siswas = Siswa::query()
            ->when($request->search, function ($q) use ($request) {
                // Membungkus OR dalam closure agar menghasilkan tanda kurung di SQL native
                $q->where(function ($query) use ($request) {
                    $query->where('nama', 'like', '%' . $request->search . '%')
                          ->orWhere('no_hp', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->kategori && $request->kategori != 'semua', function ($q) use ($request) {
                $q->where('kategori_latihan', $request->kategori);
            })
            ->latest()
            ->paginate(10);

        // =========================
        // Statistik Kartu
        // =========================
        $totalSiswa = Siswa::count();
        $totalU10 = Siswa::where('kategori_latihan', 'U-10')->count();
        $totalU13 = Siswa::where('kategori_latihan', 'U-13')->count();
        $totalU15 = Siswa::where('kategori_latihan', 'U-15')->count();
        $totalU18 = Siswa::where('kategori_latihan', 'U-18')->count();

        // =========================
        // Grafik Pertumbuhan Siswa (kumulatif)
        // =========================
        $pertumbuhan = Siswa::select(
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as bulan"),
                DB::raw("COUNT(*) as total")
            )
            ->groupBy('bulan')
            ->orderByRaw('MIN(created_at)')
            ->get();

        $labelsPertumbuhan = $pertumbuhan->pluck('bulan')->toArray();

        $dataPertumbuhan = [];
        $sum = 0;
        foreach ($pertumbuhan as $p) {
            $sum += $p->total;
            $dataPertumbuhan[] = $sum;
        }

        return view('admin.siswas.index', compact(
            'siswas',
            'totalSiswa',
            'totalU10',
            'totalU13',
            'totalU15',
            'totalU18',
            'labelsPertumbuhan',
            'dataPertumbuhan'
        ));
    }

    /**
     * Menampilkan detail profil siswa dan data pendaftarannya.
     */
    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);

        $pendaftaran = Pendaftaran::where('nama', $siswa->nama)->first();

        return view('admin.siswas.show', compact(
            'siswa',
            'pendaftaran'
        ));
    }

    /**
     * Menampilkan form edit data siswa.
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        return view('admin.siswas.edit', compact('siswa'));
    }

    /**
     * Memperbarui data siswa di tabel siswa dan pendaftaran secara simultan.
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'kategori_latihan' => 'required|in:U-10,U-13,U-15,U-18',
            'no_hp' => 'nullable',
            'nama_orang_tua' => 'nullable',
            'alamat' => 'nullable',
        ]);

        // Sinkronisasi pembaruan ke tabel pendaftarans berdasarkan nama lama siswa
        Pendaftaran::where('nama', $siswa->nama)
            ->update([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'nama_orang_tua' => $request->nama_orang_tua,
                'alamat' => $request->alamat,
                'kategori_latihan' => $request->kategori_latihan,
            ]);

        // Pembaruan data di tabel siswas
        $siswa->update([
            'nama' => $request->nama,
            'kategori_latihan' => $request->kategori_latihan,
            'no_hp' => $request->no_hp,
            'nama_orang_tua' => $request->nama_orang_tua,
            'alamat' => $request->alamat,
        ]);

        return redirect()
            ->route('admin.siswas.show', $siswa->id)
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa dari sistem database.
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()
            ->route('admin.siswas.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}