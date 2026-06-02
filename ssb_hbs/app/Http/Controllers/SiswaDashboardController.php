<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        return view('siswa.dashboard');
    }

    public function profil()
    {
        return view('siswa.profil');
    }

    public function jadwalLatihan()
    {
        return view('siswa.jadwal-latihan');
    }

    public function jadwalTurnamen()
    {
        return view('siswa.jadwal-turnamen');
    }

    private function getSiswaId()
    {
        $user = auth()->user();

        $siswaId = DB::table('siswas')
            ->where('user_id', $user->id)
            ->value('id');

        if (!$siswaId) {
            $siswaId = DB::table('siswas')->insertGetId([
                'user_id' => $user->id,
                'nama' => $user->name,
                'kategori_latihan' => 'U-12',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $siswaId;
    }

    public function pembayaran()
    {
        $siswaId = $this->getSiswaId();

        $tagihanAktif = DB::table('tagihan_spps')
            ->where('siswa_id', $siswaId)
            ->whereIn('status', ['Belum Bayar', 'Ditolak'])
            ->orderBy('tahun', 'asc')
            ->orderBy('id', 'asc')
            ->first();

        $riwayatSpp = DB::table('tagihan_spps')
            ->where('siswa_id', $siswaId)
            ->orderBy('tahun', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('siswa.pembayaran', compact('tagihanAktif', 'riwayatSpp'));
    }

    public function uploadPembayaran(Request $request)
    {
        $request->validate([
            'tagihan_spp_id' => 'required|exists:tagihan_spps,id',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            $siswaId = $this->getSiswaId();

            $tagihan = DB::table('tagihan_spps')
                ->where('id', $request->tagihan_spp_id)
                ->where('siswa_id', $siswaId)
                ->first();

            if (!$tagihan) {
                abort(403, 'Tagihan tidak ditemukan.');
            }

            if (!in_array($tagihan->status, ['Belum Bayar', 'Ditolak'])) {
                abort(400, 'Tagihan ini sudah dibayar atau sedang menunggu verifikasi.');
            }

            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bukti_pembayaran'), $filename);

            DB::table('tagihan_spps')
                ->where('id', $tagihan->id)
                ->update([
                    'bukti_pembayaran' => $filename,
                    'tanggal_bayar' => now(),
                    'status' => 'Menunggu Verifikasi',
                    'updated_at' => now(),
                ]);
        });

        return redirect()
            ->route('siswa.pembayaran')
            ->with('success', 'Bukti pembayaran SPP berhasil dikirim. Silakan tunggu verifikasi admin.');
    }

    public function jersey()
    {
        return view('siswa.jersey');
    }

    public function pesanJersey(Request $request)
    {
        $request->validate([
            'tipe_jersey' => 'required|string',
            'ukuran' => 'required|in:S,M,L,XL,XXL',
            'nama_punggung' => 'nullable|string|max:20',
            'nomor_punggung' => 'nullable|numeric|min:1|max:99',
        ]);

        DB::transaction(function () use ($request) {
            $siswaId = $this->getSiswaId();

            $harga = $request->tipe_jersey === 'Training' ? 100000 : 120000;

            DB::table('pesanan_jerseys')->insert([
                'siswa_id' => $siswaId,
                'tipe_jersey' => $request->tipe_jersey,
                'ukuran' => $request->ukuran,
                'nama_punggung' => $request->nama_punggung,
                'nomor_punggung' => $request->nomor_punggung,
                'harga' => $harga,
                'status' => 'Menunggu',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()
            ->route('siswa.jersey')
            ->with('success', 'Pesanan jersey berhasil dikirim. Silakan tunggu konfirmasi admin.');
    }

    public function riwayatAbsensi()
    {
        return view('siswa.riwayat-absensi');
    }
}