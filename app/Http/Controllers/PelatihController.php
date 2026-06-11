<?php

namespace App\Http\Controllers;

use App\Models\Pelatih;
use Illuminate\Http\Request;

class PelatihController extends Controller
{
    /**
     * Menampilkan daftar pelatih dengan fitur pencarian, filter, dan statistik lengkap.
     */
    public function index(Request $request)
    {
        // Mengoptimalkan query dengan menghitung jumlah relasi jadwal latihan per pelatih
        $query = Pelatih::withCount('jadwalLatihans');

        // Filter 1: Search nama pelatih
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter 2: Filter berdasarkan lisensi pelatih
        if ($request->filled('lisensi')) {
            $query->where('lisensi', $request->lisensi);
        }

        // Eksekusi data pelatih terbaru
        $pelatih = $query->latest()->get();

        // Mengambil data statistik kartu
        $totalPelatih = Pelatih::count();
        $totalNasionalC = Pelatih::where('lisensi', 'Nasional C')->count();
        $totalNasionalD = Pelatih::where('lisensi', 'Nasional D')->count();
        $totalNasionalB = Pelatih::where('lisensi', 'Nasional B')->count();

        // Mengambil daftar lisensi unik langsung dari database untuk opsi dropdown filter view
        $daftarLisensi = Pelatih::select('lisensi')
            ->distinct()
            ->pluck('lisensi');

        return view('admin.pelatih.index', compact(
            'pelatih',
            'totalPelatih',
            'totalNasionalC',
            'totalNasionalD',
            'totalNasionalB',
            'daftarLisensi'
        ));
    }

    /**
     * Menampilkan form untuk menambahkan data pelatih baru.
     */
    public function create()
    {
        return view('admin.pelatih.create');
    }

    /**
     * Menyimpan data pelatih baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'lisensi' => 'required|string',
            'no_hp' => 'required|string|max:20',
        ]);

        Pelatih::create([
            'nama' => $request->nama,
            'lisensi' => $request->lisensi,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()
            ->route('admin.pelatih.index')
            ->with('success', 'Pelatih berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data pelatih.
     */
    public function edit($id)
    {
        $pelatih = Pelatih::findOrFail($id);

        return view('admin.pelatih.edit', compact('pelatih'));
    }

    /**
     * Memperbarui data pelatih di database.
     */
    public function update(Request $request, $id)
    {
        $pelatih = Pelatih::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'lisensi' => 'required|string',
            'no_hp' => 'required|string|max:20',
        ]);

        $pelatih->update([
            'nama' => $request->nama,
            'lisensi' => $request->lisensi,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()
            ->route('admin.pelatih.index')
            ->with('success', 'Pelatih berhasil diperbarui.');
    }

    /**
     * Menghapus data pelatih dari database dengan proteksi integritas relasi jadwal.
     */
    public function destroy($id)
    {
        $pelatih = Pelatih::findOrFail($id);

        // Cegah hapus jika pelatih terkait masih terikat dengan jadwal latihan aktif
        if ($pelatih->jadwalLatihans()->count() > 0) {
            return back()->with(
                'error',
                'Pelatih tidak dapat dihapus karena masih memiliki jadwal latihan.'
            );
        }

        $pelatih->delete();

        return redirect()
            ->route('admin.pelatih.index')
            ->with('success', 'Pelatih berhasil dihapus.');
    }
}