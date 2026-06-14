<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JadwalLatihan;
use App\Models\Siswa;
use App\Models\Absensi;
use Carbon\Carbon;

class PelatihAbsensiController extends Controller
{
    // ─── HELPER: pelatih login ────────────────────────────────────────────────
    private function getPelatih()
    {
        $user = auth()->user();

        abort_if($user->role !== 'pelatih', 403, 'Akses hanya untuk pelatih');

        $pelatih = DB::table('pelatihs')->where('user_id', $user->id)->first();

        abort_if(!$pelatih, 404, 'Data pelatih tidak ditemukan');

        return $pelatih;
    }

    // ─── INDEX ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $pelatih = $this->getPelatih();

        // ── 1. Semua jadwal milik pelatih, dikelompokkan per hari
        $jadwalLatihans = JadwalLatihan::where('pelatih_id', $pelatih->id)
            ->orderBy('jam_mulai')
            ->get();

        $jadwalPerHari = $jadwalLatihans->groupBy('hari');  // ['Senin' => Collection, ...]

        // ── 2. Hari ini (dalam Bahasa Indonesia)
        Carbon::setLocale('id');
        $hariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];
        $todayHari = $hariMap[now()->format('l')];
        $today     = now()->translatedFormat('d F Y');
        $now       = now()->format('H:i');

        // ── 3. Siapkan siswa per jadwal (grouped by kategori_latihan)
        //       + pre-load absensi hari ini per jadwal
        $todayDate      = now()->toDateString();
        $allKategori    = $jadwalLatihans->pluck('kategori_latihan')->unique();

        // Ambil semua siswa aktif yang relevan dengan semua kategori pelatih ini
        $allSiswa = Siswa::whereIn('kategori_latihan', $allKategori)
            ->where('status_verifikasi', 'Diterima')
            ->orderBy('nama')
            ->get();

        // Absensi hari ini milik pelatih ini (semua jadwal)
        $absensiHariIni = Absensi::whereIn('jadwal_latihan_id', $jadwalLatihans->pluck('id'))
            ->whereDate('tanggal', $todayDate)
            ->get()
            ->groupBy('jadwal_latihan_id');   // [jadwal_id => Collection<Absensi>]

        // Build data untuk JS:  { jadwal_id: [{id, nama, foto, status_hari_ini}] }
        $siswaPerJadwal      = [];
        $siswaCountPerKategori = [];

        foreach ($jadwalLatihans as $jadwal) {
            $siswas = $allSiswa->where('kategori_latihan', $jadwal->kategori_latihan);
            $absJ   = ($absensiHariIni[$jadwal->id] ?? collect())->keyBy('siswa_id');

            $siswaCountPerKategori[$jadwal->kategori_latihan] = $siswas->count();

            $siswaPerJadwal[$jadwal->id] = $siswas->map(function ($s) use ($absJ) {
                $absen = $absJ[$s->id] ?? null;
                return [
                    'id'             => $s->id,
                    'nama'           => $s->nama,
                    'nama_ortu'      => $s->nama_orang_tua,
                    'foto'           => $s->foto_siswa ? asset('storage/' . $s->foto_siswa) : null,
                    'status_hari_ini'=> $absen ? $absen->status : null,
                    'keterangan'     => $absen ? $absen->keterangan : null,
                ];
            })->values()->all();
        }

        // Jumlah siswa yang sudah diabsen hari ini, per jadwal
        $absensiCountPerJadwal = [];
        foreach ($jadwalLatihans as $jadwal) {
            $absensiCountPerJadwal[$jadwal->id] = ($absensiHariIni[$jadwal->id] ?? collect())->count();
        }

        // ── 4. Riwayat absensi (paginated, filterable by cari)
        $absensis = Absensi::with(['siswa', 'jadwal'])
            ->whereHas('jadwal', fn($q) => $q->where('pelatih_id', $pelatih->id))
            ->when($request->cari, fn($q) =>
                $q->whereHas('siswa', fn($s) => $s->where('nama', 'like', '%' . $request->cari . '%'))
            )
            ->latest('tanggal')
            ->paginate(15);

        // ── 5. Summary stats (all-time, milik pelatih)
        $baseQuery = Absensi::whereHas('jadwal', fn($q) => $q->where('pelatih_id', $pelatih->id));

        $totalHadir = (clone $baseQuery)->where('status', 'Hadir')->count();
        $totalIzin  = (clone $baseQuery)->where('status', 'Izin')->count();
        $totalAlpa  = (clone $baseQuery)->where('status', 'Alpa')->count();
        $totalAbsensi = $totalHadir + $totalIzin + $totalAlpa;
        $persentaseKehadiran = $totalAbsensi > 0 ? round(($totalHadir / $totalAbsensi) * 100) : 0;

        return view('pelatih.absensi', compact(
            'jadwalPerHari',
            'todayHari',
            'today',
            'now',
            'siswaPerJadwal',
            'siswaCountPerKategori',
            'absensiCountPerJadwal',
            'absensis',
            'totalHadir',
            'totalIzin',
            'totalAlpa',
            'persentaseKehadiran',
        ));
    }

    // ─── SIMPAN (batch-friendly, called per siswa via fetch) ─────────────────
    public function simpan(Request $request)
    {
        $pelatih = $this->getPelatih();

        $request->validate([
            'jadwal_latihan_id' => 'required|exists:jadwal_latihans,id',
            'siswa_id'          => 'required|exists:siswas,id',
            'status'            => 'required|in:Hadir,Izin,Alpa',
            'keterangan'        => 'nullable|string|max:255',
        ]);

        $jadwal = JadwalLatihan::where('id', $request->jadwal_latihan_id)
            ->where('pelatih_id', $pelatih->id)
            ->firstOrFail();

        Absensi::updateOrCreate(
            [
                'siswa_id'          => $request->siswa_id,
                'jadwal_latihan_id' => $jadwal->id,
                'tanggal'           => now()->toDateString(),
            ],
            [
                'status'      => $request->status,
                'keterangan'  => $request->keterangan,
            ]
        );

        // Supports both AJAX (fetch) and normal form POST
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Absensi berhasil disimpan.');
    }

    // ─── UPDATE (edit riwayat) ────────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $pelatih = $this->getPelatih();

        $request->validate([
            'status'      => 'required|in:Hadir,Izin,Alpa',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        $absensi = Absensi::whereHas('jadwal', fn($q) => $q->where('pelatih_id', $pelatih->id))
            ->findOrFail($id);

        $absensi->update([
            'status'     => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Status absensi berhasil diubah.');
    }
}