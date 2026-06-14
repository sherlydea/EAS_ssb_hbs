<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaTurnamenController extends Controller
{
    /**
     * Menampilkan jadwal turnamen aktif dan riwayat turnamen milik siswa.
     */
    public function index()
    {
        // Mengambil data siswa berdasarkan akun user yang login
        $siswa = DB::table('siswas')
            ->where('user_id', auth()->user()->id)
            ->first();

        // Pengaman: Jika user login tidak terdaftar di tabel siswas (ex: Admin/Pelatih)
        if (!$siswa) {
            return redirect()->route('home')->with('error', 'Data siswa tidak ditemukan atau Anda tidak memiliki akses.');
        }

        // BAGIAN 1: Mengambil data turnamen yang berstatus Aktif (Diperbarui dengan menambahkan biaya)
        $turnamens = DB::table('turnamen_siswas')
            ->join('turnamens', 'turnamen_siswas.turnamen_id', '=', 'turnamens.id')
            ->where('turnamen_siswas.siswa_id', $siswa->id)
            ->where('turnamen_siswas.status_turnamen', 'Aktif')
            ->select(
                'turnamen_siswas.id as turnamen_siswa_id', // Beri alias agar ID pivot tidak tertimpa ID turnamen
                'turnamen_siswas.biaya',
                'turnamen_siswas.status_pembayaran',
                'turnamen_siswas.bukti_pembayaran',
                'turnamen_siswas.status_turnamen',
                'turnamens.nama_turnamen',
                'turnamens.tanggal',
                'turnamens.lokasi'
            )
            ->orderBy('turnamens.tanggal', 'asc')
            ->get();

        // BAGIAN 2: Mengambil seluruh riwayat turnamen (Diperbarui dengan menambahkan biaya)
        $riwayat = DB::table('turnamen_siswas')
            ->join('turnamens', 'turnamen_siswas.turnamen_id', '=', 'turnamens.id')
            ->where('turnamen_siswas.siswa_id', $siswa->id)
            ->select(
                'turnamen_siswas.id as turnamen_siswa_id',
                'turnamen_siswas.biaya',
                'turnamen_siswas.status_pembayaran',
                'turnamen_siswas.bukti_pembayaran',
                'turnamen_siswas.status_turnamen',
                'turnamen_siswas.created_at as tanggal_daftar',
                'turnamens.nama_turnamen',
                'turnamens.tanggal',
                'turnamens.lokasi'
            )
            ->orderBy('turnamen_siswas.created_at', 'desc')
            ->get();

        return view('siswa.jadwal-turnamen', compact('siswa', 'turnamens', 'riwayat'));
    }

    /**
     * Memproses upload bukti pembayaran turnamen siswa.
     */
    public function uploadBukti(Request $request, $id)
    {
        // Validasi ekstensi dan ukuran berkas (Maksimal 2MB)
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cek apakah data pivot turnamen_siswas memang benar-benar ada
        $cekPivot = DB::table('turnamen_siswas')->where('id', $id)->exists();
        if (!$cekPivot) {
            return redirect()->route('siswa.jadwal-turnamen')->with('error', 'Data pendaftaran turnamen tidak ditemukan.');
        }

        // Proses penyimpanan file gambar ke direktori public
        $file = $request->file('bukti_pembayaran');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(); // Menggunakan uniqid agar nama file selalu unik

        $file->move(public_path('uploads/bukti_turnamen'), $filename);

        // Update data pembayaran di database
        DB::table('turnamen_siswas')
            ->where('id', $id)
            ->update([
                'bukti_pembayaran' => $filename,
                'status_pembayaran' => 'Menunggu Konfirmasi',
                'updated_at' => now(),
            ]);

        // Redirect langsung menggunakan rute resmi name route agar aman
        return redirect()
            ->route('siswa.jadwal-turnamen')
            ->with('success', 'Bukti pembayaran turnamen berhasil diupload. Menunggu konfirmasi admin.');
    }
}