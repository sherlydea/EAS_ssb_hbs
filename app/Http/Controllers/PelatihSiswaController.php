<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelatihSiswaController extends Controller
{
    /**
     * Ambil kategori latihan yang diajar oleh pelatih yang sedang login.
     */
    private function getKategoriPelatih(): array
    {
        $pelatih = DB::table('pelatihs')
            ->where('user_id', Auth::id())
            ->first();

        if (!$pelatih) return [];

        return DB::table('jadwal_latihans')
            ->where('pelatih_id', $pelatih->id)
            ->whereNotNull('kategori_latihan')
            ->distinct()
            ->pluck('kategori_latihan')
            ->toArray();
    }

    public function index(Request $request)
    {
        $kategoriPelatih = $this->getKategoriPelatih();

        if (empty($kategoriPelatih)) {
            return view('pelatih.siswa', [
                'turnamens' => collect(), 'turnamenAktif' => null, 'turnamenId' => null,
                'siswas' => collect(), 'kategoriList' => collect(), 'statusList' => collect(),
                'selectedSiswaIds' => [], 'totalSiswa' => 0, 'memenuhiKriteria' => 0,
                'sudahDipilih' => 0, 'rataRataKehadiran' => 0, 'kategoriPelatih' => [],
                'riwayat' => collect(), 'siswaDataJs' => collect()
            ]);
        }

        $turnamens = DB::table('turnamens')->orderBy('tanggal', 'asc')->get();
        $turnamenId = $request->input('turnamen_id');

        if (!$turnamenId) {
            $turnamenId = DB::table('turnamens')
                ->whereDate('tanggal', '>=', now()->toDateString())
                ->orderBy('tanggal', 'asc')
                ->value('id') ?? DB::table('turnamens')->orderBy('tanggal', 'desc')->value('id');
        }

        $turnamenAktif = $turnamenId ? DB::table('turnamens')->where('id', $turnamenId)->first() : null;

        // --- Logika Reset (menggunakan parameter clear_selection) ---
        $selectedSiswaIds = [];
        if (!$request->has('clear_selection')) {
            $selectedSiswaIds = $turnamenId
                ? DB::table('peserta_turnamens')
                    ->where('turnamen_id', $turnamenId)
                    ->pluck('siswa_id')
                    ->map(fn($id) => (int) $id)
                    ->toArray()
                : [];
        }

        $query = DB::table('siswas')
            ->leftJoin('absensis', 'siswas.id', '=', 'absensis.siswa_id')
            ->select(
                'siswas.*',
                DB::raw('COUNT(absensis.id) as total_absensi'),
                DB::raw("SUM(CASE WHEN absensis.status = 'Hadir' THEN 1 ELSE 0 END) as total_hadir")
            )
            ->whereIn('siswas.kategori_latihan', $kategoriPelatih)
            ->where('siswas.status_verifikasi', 'Diterima')
            ->groupBy('siswas.id');

        if ($turnamenAktif && preg_match('/U-?(\d+)/i', $turnamenAktif->nama_turnamen ?? '', $m)) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, siswas.tanggal_lahir, CURDATE()) <= ?', [(int)$m[1]]);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('siswas.nama', 'like', "%$search%")
                  ->orWhere('siswas.no_hp', 'like', "%$search%")
                  ->orWhere('siswas.nama_orang_tua', 'like', "%$search%");
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua' && in_array($request->kategori, $kategoriPelatih)) {
            $query->where('siswas.kategori_latihan', $request->kategori);
        }

        $siswas = $query->get()->map(function ($siswa) use ($selectedSiswaIds) {
            $siswa->umur = $siswa->tanggal_lahir ? Carbon::parse($siswa->tanggal_lahir)->age : '-';
            $siswa->persentase_kehadiran = $siswa->total_absensi > 0 ? round(($siswa->total_hadir / $siswa->total_absensi) * 100) : 0;
            $siswa->is_selected = in_array((int) $siswa->id, $selectedSiswaIds, true);
            return $siswa;
        });

        if ($request->filled('kehadiran') && $request->kehadiran !== 'semua') {
            $siswas = $siswas->filter(fn($s) => $s->persentase_kehadiran >= (int)$request->kehadiran)->values();
        }

        $sort = $request->sort ?? 'nama_asc';
        $siswas = match ($sort) {
            'nama_desc'      => $siswas->sortByDesc('nama')->values(),
            'kehadiran_desc' => $siswas->sortByDesc('persentase_kehadiran')->values(),
            default          => $siswas->sortBy('nama')->values(),
        };

        $totalSiswa = DB::table('siswas')->whereIn('kategori_latihan', $kategoriPelatih)->where('status_verifikasi', 'Diterima')->count();
        $memenuhiKriteria = $siswas->count();
        $sudahDipilih = count($selectedSiswaIds);
        $rataRataKehadiran = $siswas->count() > 0 ? round($siswas->avg('persentase_kehadiran')) : 0;
        $kategoriList = collect($kategoriPelatih);
        
        $siswaDataJs = $siswas->map(fn($s) => [
            'id' => $s->id, 'nama' => $s->nama, 'kat' => $s->kategori_latihan ?? '—', 
            'hadir' => $s->persentase_kehadiran, 'hp' => $s->no_hp ?? '—'
        ]);

        $riwayat = $turnamenId ? DB::table('turnamen_siswas')
            ->join('siswas', 'turnamen_siswas.siswa_id', '=', 'siswas.id')
            ->join('turnamens', 'turnamen_siswas.turnamen_id', '=', 'turnamens.id')
            ->select('turnamen_siswas.*', 'siswas.nama as nama_siswa', 'siswas.kategori_latihan', 'siswas.jenis_kelamin', 'siswas.no_hp', 'turnamens.nama_turnamen')
            ->where('turnamen_siswas.turnamen_id', $turnamenId)
            ->orderBy('siswas.nama')
            ->get() : collect();

        return view('pelatih.siswa', compact(
            'turnamens', 'turnamenAktif', 'turnamenId', 'siswas', 'kategoriList',
            'selectedSiswaIds', 'totalSiswa', 'memenuhiKriteria', 'sudahDipilih',
            'rataRataKehadiran', 'kategoriPelatih', 'siswaDataJs', 'riwayat'
        ));
    }

    public function simpanPeserta(Request $request)
    {
        $request->validate(['turnamen_id' => 'required|exists:turnamens,id', 'siswa_ids' => 'required|array']);
        
        $kategoriPelatih = $this->getKategoriPelatih();
        $siswaIds = collect($request->siswa_ids)->unique()->filter(function ($id) use ($kategoriPelatih) {
            return DB::table('siswas')->where('id', $id)->whereIn('kategori_latihan', $kategoriPelatih)->exists();
        });

        if ($siswaIds->isEmpty()) return back()->with('error', 'Data tidak valid.');

        $turnamenId = $request->turnamen_id;
        DB::transaction(function () use ($turnamenId, $siswaIds) {
            foreach ($siswaIds as $id) {
                DB::table('peserta_turnamens')->updateOrInsert(
                    ['turnamen_id' => $turnamenId, 'siswa_id' => $id],
                    ['pelatih_id' => Auth::id(), 'updated_at' => now(), 'created_at' => now()]
                );
                DB::table('turnamen_siswas')->updateOrInsert(
                    ['turnamen_id' => $turnamenId, 'siswa_id' => $id],
                    ['biaya' => 0, 'status_pembayaran' => 'Belum Bayar', 'status_turnamen' => 'Aktif', 'updated_at' => now(), 'created_at' => now()]
                );
            }
        });

        return redirect()->route('pelatih.siswa.index', [
            'turnamen_id' => $turnamenId,
            'clear_selection' => 1
        ])->with('success', 'Peserta berhasil disimpan.');
    }
}