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
        $siswa = DB::table('siswas')
            ->where('user_id', auth()->user()->id)
            ->first();

        return view('siswa.profil', compact('siswa'));
    }
public function jadwalLatihan()
{
    $siswaId = $this->getSiswaId();

    $siswa = DB::table('siswas')
        ->where('id', $siswaId)
        ->first();

    $riwayatLatihan = DB::table('jadwal_latihans')
        ->where('kategori_latihan', $siswa->kategori_latihan ?? 'U-12')
        ->orderBy('hari', 'asc')
        ->orderBy('jam_mulai', 'asc')
        ->get();

    return view('siswa.jadwal-latihan', compact('siswa', 'riwayatLatihan'));
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

    public function riwayatPembayaran()
    {
        return redirect()->route('siswa.pembayaran');
    }

    public function jersey()
    {
        $siswaId = $this->getSiswaId();

        $jerseys = collect([
            (object) [
                'tipe_jersey' => 'Home',
                'harga' => 120000,
                'keterangan' => 'Jersey utama SSB HBS',
            ],
            (object) [
                'tipe_jersey' => 'Away',
                'harga' => 120000,
                'keterangan' => 'Jersey tandang SSB HBS',
            ],
            (object) [
                'tipe_jersey' => 'Training',
                'harga' => 100000,
                'keterangan' => 'Jersey latihan siswa',
            ],
        ]);

        $pesananJerseys = DB::table('pesanan_jerseys')
            ->where('siswa_id', $siswaId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.jersey', compact('jerseys', 'pesananJerseys'));
    }

    public function pesanJersey(Request $request)
    {
        $request->validate([
            'tipe_jersey' => 'required|in:Home,Away,Training',
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
                'bukti_pembayaran' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()
            ->route('siswa.jersey')
            ->with('success', 'Pesanan jersey berhasil dikirim. Silakan tunggu konfirmasi admin.');
    }

    public function uploadBuktiJersey(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $siswaId = $this->getSiswaId();

        $pesanan = DB::table('pesanan_jerseys')
            ->where('id', $id)
            ->where('siswa_id', $siswaId)
            ->first();

        if (!$pesanan) {
            return redirect()
                ->route('siswa.jersey')
                ->withErrors(['bukti_pembayaran' => 'Pesanan jersey tidak ditemukan.']);
        }

        if ($pesanan->status !== 'Diproses') {
            return redirect()
                ->route('siswa.jersey')
                ->withErrors(['bukti_pembayaran' => 'Upload bukti hanya bisa dilakukan setelah pesanan dikonfirmasi admin.']);
        }

        $file = $request->file('bukti_pembayaran');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('uploads/bukti_jersey'), $filename);

        DB::table('pesanan_jerseys')
            ->where('id', $pesanan->id)
            ->update([
                'bukti_pembayaran' => $filename,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('siswa.jersey')
            ->with('success', 'Bukti pembayaran jersey berhasil diupload. Silakan tunggu konfirmasi admin.');
    }

    public function riwayatAbsensi()
    {
        $siswaId = $this->getSiswaId();

        $riwayatAbsensi = DB::table('absensis')
            ->where('siswa_id', $siswaId)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('siswa.riwayat-absensi', compact('riwayatAbsensi'));
    }
}