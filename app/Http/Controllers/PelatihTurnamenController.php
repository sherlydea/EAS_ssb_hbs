<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PelatihTurnamenController extends Controller
{
    public function index()
    {
        return $this->pilihSiswa(request());
    }

    public function pilihSiswa(Request $request)
    {
        $turnamens  = DB::table('turnamens')->orderBy('tanggal')->get();
        $turnamenId = $request->input('turnamen_id');
        $turnamen   = $turnamenId
            ? DB::table('turnamens')->where('id', $turnamenId)->first()
            : $turnamens->first();

        $turnamenAktif = $turnamen;
        $turnamenId    = $turnamen->id ?? null;

        $batasUsia = null;
        if ($turnamen && preg_match('/U-?(\d+)/i', $turnamen->nama_turnamen ?? '', $m)) {
            $batasUsia = (int)$m[1];
        }

        $query = DB::table('siswas')->where('status_verifikasi', 'Diterima');

        if ($batasUsia) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= ?', [$batasUsia]);
        }

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori_latihan', $request->kategori);
        }

        // ── Sorting ──
        switch ($request->input('sort', 'nama_asc')) {
            case 'nama_desc': $query->orderBy('nama', 'desc'); break;
            case 'umur_asc': $query->orderBy('tanggal_lahir', 'desc'); break;
            case 'umur_desc': $query->orderBy('tanggal_lahir', 'asc'); break;
            default: $query->orderBy('nama', 'asc');
        }

        $dipilihIds = $turnamen
            ? DB::table('peserta_turnamens')
                ->where('turnamen_id', $turnamen->id)
                ->pluck('siswa_id')
                ->map(fn($id) => (int)$id)
                ->toArray()
            : [];

        $siswas = $query->get()->map(function ($s) use ($dipilihIds) {
            $total = DB::table('absensis')->where('siswa_id', $s->id)->count();
            $hadir = DB::table('absensis')->where('siswa_id', $s->id)->where('status', 'Hadir')->count();

            $s->persentase_kehadiran = $total > 0 ? round(($hadir / $total) * 100) : 0;
            $s->pct_kehadiran        = $s->persentase_kehadiran;
            $s->is_selected          = in_array((int)$s->id, $dipilihIds);

            return $s;
        });

        if ($request->filled('kehadiran') && $request->kehadiran !== 'semua') {
            $min = (int)$request->kehadiran;
            $siswas = $siswas->filter(fn($s) => $s->persentase_kehadiran >= $min)->values();
        }

        if ($request->input('sort') === 'kehadiran_desc') {
            $siswas = $siswas->sortByDesc('persentase_kehadiran')->values();
        }

        $totalSiswa       = DB::table('siswas')->where('status_verifikasi', 'Diterima')->count();
        $memenuhiKriteria  = $siswas->count();
        $sudahDipilih      = count($dipilihIds);
        $rataRataKehadiran = $siswas->count() > 0 ? round($siswas->avg('persentase_kehadiran')) : 0;
        $kategoriList      = DB::table('siswas')->distinct()->pluck('kategori_latihan');
        $selectedSiswaIds  = $dipilihIds;

        $siswaDataJs = $siswas->map(function ($s) {
            return [
                'id'    => $s->id,
                'nama'  => $s->nama,
                'kat'   => $s->kategori_latihan ?? '—',
                'jk'    => $s->jenis_kelamin ?? null,
                'hadir' => $s->persentase_kehadiran,
                'hp'    => $s->no_hp ?? '—',
            ];
        })->values();

        $riwayat = collect();
        if ($turnamen) {
            $riwayat = DB::table('turnamen_siswas')
                ->join('siswas', 'turnamen_siswas.siswa_id', '=', 'siswas.id')
                ->where('turnamen_siswas.turnamen_id', $turnamen->id)
                ->select('turnamen_siswas.*', 'siswas.nama as nama_siswa', 'siswas.kategori_latihan', 'siswas.jenis_kelamin', 'siswas.no_hp')
                ->orderBy('siswas.nama')
                ->get();
        }

        return view('pelatih.siswa', compact(
            'turnamens', 'turnamen', 'turnamenAktif', 'turnamenId',
            'siswas', 'dipilihIds', 'selectedSiswaIds', 'siswaDataJs',
            'totalSiswa', 'memenuhiKriteria', 'sudahDipilih', 'rataRataKehadiran',
            'kategoriList', 'batasUsia', 'riwayat'
        ));
    }

    public function riwayat()
    {
        $riwayat = DB::table('turnamen_siswas')
            ->join('siswas','turnamen_siswas.siswa_id','=','siswas.id')
            ->join('turnamens','turnamen_siswas.turnamen_id','=','turnamens.id')
            ->select(
                'turnamen_siswas.*',
                'siswas.nama as nama_siswa',
                'siswas.kategori_latihan',
                'siswas.jenis_kelamin',
                'siswas.no_hp',
                'turnamens.nama_turnamen',
                'turnamens.tanggal',
                'turnamens.lokasi'
            )
            ->latest()
            ->get();

        return view('pelatih.riwayat-turnamen', compact('riwayat'));
    }

    public function simpanPeserta(Request $request)
    {
        $request->validate([
            'turnamen_id' => 'required|exists:turnamens,id',
            'siswa_ids'   => 'required|array|min:1',
            'siswa_ids.*' => 'exists:siswas,id',
        ]);

        $turnamenId = (int)$request->turnamen_id;
        $siswaIds   = array_map('intval', $request->siswa_ids);
        $pelatihId  = auth()->id();

        foreach ($siswaIds as $id) {
            DB::table('peserta_turnamens')->updateOrInsert(
                ['turnamen_id' => $turnamenId, 'siswa_id' => $id],
                ['pelatih_id' => $pelatihId, 'updated_at' => now(), 'created_at' => now()]
            );

            DB::table('turnamen_siswas')->updateOrInsert(
                ['turnamen_id' => $turnamenId, 'siswa_id' => $id],
                [
                    'biaya' => 0,
                    'status_pembayaran' => 'Belum Bayar',
                    'status_turnamen' => 'Aktif',
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );
        }

        return redirect()
            ->route('pelatih.turnamen.pilihSiswa', ['turnamen_id' => $turnamenId])
            ->with('success', count($siswaIds) . ' siswa berhasil diperbarui di turnamen.');
    }

    public function hapusPeserta($turnamen_id, $siswa_id)
    {
        DB::table('peserta_turnamens')->where('turnamen_id', $turnamen_id)->where('siswa_id', $siswa_id)->delete();
        DB::table('turnamen_siswas')->where('turnamen_id', $turnamen_id)->where('siswa_id', $siswa_id)->delete();
        return back()->with('success', 'Peserta berhasil dihapus.');
    }

    public function editPeserta($id)
    {
        $row = DB::table('turnamen_siswas')->join('siswas', 'turnamen_siswas.siswa_id', '=', 'siswas.id')->join('turnamens', 'turnamen_siswas.turnamen_id', '=', 'turnamens.id')->where('turnamen_siswas.id', $id)->select('turnamen_siswas.*', 'siswas.nama as nama_siswa', 'turnamens.nama_turnamen')->first();
        abort_if(!$row, 404);
        return view('pelatih.peserta-edit', compact('row'));
    }

    public function updatePeserta(Request $request, $id)
    {
        $request->validate(['biaya' => 'required|numeric', 'status_pembayaran' => 'required', 'status_turnamen' => 'required']);
        $row = DB::table('turnamen_siswas')->where('id', $id)->first();
        abort_if(!$row, 404);
        DB::table('turnamen_siswas')->where('id', $id)->update([
            'biaya' => $request->biaya,
            'status_pembayaran' => $request->status_pembayaran,
            'status_turnamen' => $request->status_turnamen,
            'updated_at' => now()
        ]);
        return redirect()->route('pelatih.turnamen.pilihSiswa', ['turnamen_id' => $row->turnamen_id])->with('success', 'Data diperbarui.');
    }

    public function showPeserta($id)
    {
        $row = DB::table('turnamen_siswas')->join('siswas', 'turnamen_siswas.siswa_id', '=', 'siswas.id')->join('turnamens', 'turnamen_siswas.turnamen_id', '=', 'turnamens.id')->where('turnamen_siswas.id', $id)->select('turnamen_siswas.*', 'siswas.nama as nama_siswa', 'turnamens.nama_turnamen')->first();
        abort_if(!$row, 404);
        return view('pelatih.peserta-show', compact('row'));
    }

    public function exportRiwayat(Request $request)
    {
        $turnamenId = $request->input('turnamen_id');
        $query = DB::table('turnamen_siswas')->join('siswas', 'turnamen_siswas.siswa_id', '=', 'siswas.id')->join('turnamens', 'turnamen_siswas.turnamen_id', '=', 'turnamens.id');
        if ($turnamenId) $query->where('turnamen_siswas.turnamen_id', $turnamenId);
        $data = $query->get();
        // ... logika export CSV tetap sama ...
        return response()->stream(function() use ($data) { /* ... */ }, 200, ['Content-Type' => 'text/csv']);
    }
}