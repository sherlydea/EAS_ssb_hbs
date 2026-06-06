<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaTurnamenController extends Controller
{
    public function index()
    {
        $siswa = DB::table('siswas')
            ->where('user_id', auth()->user()->id)
            ->first();

        $turnamens = DB::table('turnamen_siswas')
            ->join('turnamens', 'turnamen_siswas.turnamen_id', '=', 'turnamens.id')
            ->where('turnamen_siswas.siswa_id', $siswa->id)
            ->where('turnamen_siswas.status_turnamen', 'Aktif')
            ->select(
                'turnamen_siswas.*',
                'turnamens.nama_turnamen',
                'turnamens.tanggal',
                'turnamens.lokasi'
            )
            ->orderBy('turnamens.tanggal', 'asc')
            ->get();

        $riwayat = DB::table('turnamen_siswas')
            ->join('turnamens', 'turnamen_siswas.turnamen_id', '=', 'turnamens.id')
            ->where('turnamen_siswas.siswa_id', $siswa->id)
            ->select(
                'turnamen_siswas.*',
                'turnamens.nama_turnamen',
                'turnamens.tanggal',
                'turnamens.lokasi'
            )
            ->orderBy('turnamen_siswas.created_at', 'desc')
            ->get();

        return view('siswa.jadwal-turnamen', compact('siswa', 'turnamens', 'riwayat'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('bukti_pembayaran');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('uploads/bukti_turnamen'), $filename);

        DB::table('turnamen_siswas')
            ->where('id', $id)
            ->update([
                'bukti_pembayaran' => $filename,
                'status_pembayaran' => 'Menunggu Konfirmasi',
                'updated_at' => now(),
            ]);

        return redirect()
            ->back()
            ->with('success', 'Bukti pembayaran turnamen berhasil diupload. Menunggu konfirmasi admin.');
    }
}