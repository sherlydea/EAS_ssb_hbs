<?php

namespace App\Http\Controllers;

use App\Models\JadwalLatihan;
use App\Models\Pelatih;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalLatihanController extends Controller
{
    /**
     * Menampilkan daftar jadwal latihan dengan fitur filter dan pencarian.
     */
    public function index(Request $request)
    {
        // Mengatur lokalitas waktu Carbon ke Bahasa Indonesia
        Carbon::setLocale('id');

        // Mengambil daftar kategori unik langsung dari database untuk opsi dropdown filter
        $kategoriDaftar = JadwalLatihan::select('kategori_latihan')
            ->distinct()
            ->pluck('kategori_latihan');

        // Membuka query dasar beserta relasi pelatih
        $query = JadwalLatihan::with('pelatih');

        // Filter 1: Pencarian berdasarkan nama pelatih
        if ($request->filled('search')) {
            $query->whereHas('pelatih', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        // Filter 2: Berdasarkan hari latihan
        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        // Filter 3: Berdasarkan kategori latihan
        if ($request->filled('kategori_latihan')) {
            $query->where('kategori_latihan', $request->kategori_latihan);
        }

        // Mengurutkan data berdasarkan urutan hari Senin - Minggu secara berurutan
        $jadwalLatihan = $query
            ->orderByRaw("
                FIELD(hari,
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
                'Minggu')
            ")
            ->get();

        return view('admin.jadwal_latihan.index', compact('jadwalLatihan', 'kategoriDaftar'));
    }

    /**
     * Menampilkan form untuk membuat jadwal latihan baru.
     */
    public function create()
    {
        // Mengambil data pelatih secara unik untuk pilihan dropdown form guna menghindari duplikasi
        $pelatih = Pelatih::select('id', 'nama')
            ->distinct()
            ->get();

        return view('admin.jadwal_latihan.create', compact('pelatih'));
    }

    /**
     * Menyimpan jadwal latihan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data input sesuai nama tabel dan field database yang benar
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kategori_latihan' => 'required|string',
            'lokasi' => 'required|string',
            'pelatih_id' => 'required|exists:pelatihs,id',
        ]);

        // Menyimpan data secara eksplisit (menghindari request->all())
        JadwalLatihan::create([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kategori_latihan' => $request->kategori_latihan,
            'lokasi' => $request->lokasi,
            'pelatih_id' => $request->pelatih_id,
        ]);

        return redirect()->route('admin.jadwal-latihan.index')
            ->with('success', 'Jadwal latihan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit jadwal latihan yang dipilih.
     */
    public function edit($id)
    {
        $jadwal = JadwalLatihan::findOrFail($id);
        
        // Mengambil data pelatih secara unik untuk pilihan dropdown form edit guna menghindari duplikasi
        $pelatih = Pelatih::select('id', 'nama')
            ->distinct()
            ->get();

        return view('admin.jadwal_latihan.edit', compact('jadwal', 'pelatih'));
    }

    /**
     * Memperbarui data jadwal latihan di database.
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalLatihan::findOrFail($id);

        // Validasi data perubahan
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kategori_latihan' => 'required|string',
            'lokasi' => 'required|string',
            'pelatih_id' => 'required|exists:pelatihs,id',
        ]);

        // Memperbarui data secara eksplisit
        $jadwal->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kategori_latihan' => $request->kategori_latihan,
            'lokasi' => $request->lokasi,
            'pelatih_id' => $request->pelatih_id,
        ]);

        return redirect()->route('admin.jadwal-latihan.index')
            ->with('success', 'Jadwal latihan berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal latihan dari database.
     */
    public function destroy($id)
    {
        $jadwal = JadwalLatihan::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal-latihan.index')
            ->with('success', 'Jadwal latihan berhasil dihapus.');
    }
}