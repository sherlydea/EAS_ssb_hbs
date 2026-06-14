<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPesertaTurnamenController extends Controller
{
    /**
     * Menampilkan daftar seluruh peserta turnamen beserta relasi siswa dan turnamennya.
     */
    public function index()
    {
        $peserta = DB::table('turnamen_siswas')
            ->join('siswas', 'turnamen_siswas.siswa_id', '=', 'siswas.id')
            ->join('turnamens', 'turnamen_siswas.turnamen_id', '=', 'turnamens.id')
            ->select(
                'turnamen_siswas.*',
                'siswas.nama as nama_siswa',
                'turnamens.nama_turnamen'
            )
            ->latest()
            ->get();

        return view('admin.peserta-turnamen.index', compact('peserta'));
    }

    /**
     * Menampilkan form pendaftaran peserta ke turnamen tertentu.
     */
    public function create()
    {
        $siswas = DB::table('siswas')
            ->orderBy('nama')
            ->get();

        $turnamens = DB::table('turnamens')
            ->orderBy('tanggal')
            ->get();

        return view(
            'admin.peserta-turnamen.create',
            compact('siswas', 'turnamens')
        );
    }

    /**
     * Menyimpan relasi pendaftaran peserta turnamen ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'turnamen_id' => 'required',
            'biaya' => 'required|numeric'
        ]);

        DB::table('turnamen_siswas')->insert([
            'siswa_id' => $request->siswa_id,
            'turnamen_id' => $request->turnamen_id,
            'biaya' => $request->biaya,
            'status_pembayaran' => 'Belum Bayar',
            'status_turnamen' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.peserta-turnamen.index')
            ->with('success', 'Peserta berhasil ditambahkan.');
    }

    /**
     * Menerima dan mengonfirmasi bukti pembayaran peserta menjadi Lunas.
     */
    public function terima($id)
    {
        DB::table('turnamen_siswas')
            ->where('id', $id)
            ->update([
                'status_pembayaran' => 'Lunas',
                'updated_at' => now()
            ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    /**
     * Menolak bukti pembayaran peserta turnamen dan mengembalikannya ke status Belum Bayar.
     */
    public function tolak($id)
    {
        DB::table('turnamen_siswas')
            ->where('id', $id)
            ->update([
                'status_pembayaran' => 'Belum Bayar',
                'updated_at' => now()
            ]);

        return back()->with('success', 'Pembayaran ditolak.');
    }

    /**
     * Mengonfirmasi pembayaran peserta turnamen langsung dari rute konfirmasi spesifik.
     */
    public function konfirmasi($id)
    {
        $peserta = DB::table('turnamen_siswas')->where('id', $id)->first();

        if (!$peserta) {
            return redirect()->route('admin.peserta-turnamen.index')
                ->with('error', 'Data peserta tidak ditemukan.');
        }

        DB::table('turnamen_siswas')
            ->where('id', $id)
            ->update([
                'status_pembayaran' => 'Lunas',
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.peserta-turnamen.index')
            ->with('success', 'Pembayaran peserta turnamen telah dikonfirmasi.');
    }

    /**
     * Menampilkan form untuk mengedit data relasi peserta turnamen tertentu.
     */
    public function edit($id)
    {
        $peserta = DB::table('turnamen_siswas')
            ->where('id', $id)
            ->first();

        // Pengaman: Jika data pendaftaran tidak ditemukan di database
        if (!$peserta) {
            return redirect()->route('admin.peserta-turnamen.index')
                ->with('error', 'Data pendaftaran peserta tidak ditemukan.');
        }

        $siswas = DB::table('siswas')
            ->orderBy('nama')
            ->get();

        $turnamens = DB::table('turnamens')
            ->orderBy('nama_turnamen')
            ->get();

        return view(
            'admin.peserta-turnamen.edit',
            compact('peserta', 'siswas', 'turnamens')
        );
    }

    /**
     * Memperbarui data relasi peserta turnamen di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required',
            'turnamen_id' => 'required',
            'biaya' => 'required|numeric|min:0',
        ]);

        DB::table('turnamen_siswas')
            ->where('id', $id)
            ->update([
                'siswa_id' => $request->siswa_id,
                'turnamen_id' => $request->turnamen_id,
                'biaya' => $request->biaya,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.peserta-turnamen.index')
            ->with('success', 'Peserta berhasil diperbarui.');
    }

    /**
     * Menghapus data relasi peserta turnamen dari database.
     */
    public function destroy($id)
    {
        DB::table('turnamen_siswas')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('admin.peserta-turnamen.index')
            ->with('success', 'Peserta berhasil dihapus.');
    }
}