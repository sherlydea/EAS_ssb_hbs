<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPendaftaranController extends Controller
{
    /**
     * Menampilkan seluruh data pendaftaran
     */
    public function index(Request $request)
    {
        $query = DB::table('pendaftarans');

        // Search nama atau email
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status
        if ($request->status && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $pendaftarans = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('admin.pendaftaran.index', [
            'pendaftarans'      => $pendaftarans,
            'totalPendaftaran'  => DB::table('pendaftarans')->count(),
            'totalPending'      => DB::table('pendaftarans')->where('status', 'pending')->count(),
            'totalDiterima'     => DB::table('pendaftarans')->where('status', 'diterima')->count(),
            'totalDitolak'      => DB::table('pendaftarans')->where('status', 'ditolak')->count(),
        ]);
    }

    /**
     * Detail pendaftaran
     */
    public function show($id)
    {
        $pendaftaran = DB::table('pendaftarans')
            ->where('id', $id)
            ->first();

        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    /**
     * Terima pendaftaran siswa
     */
    public function terima($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil data pendaftaran berdasarkan ID
        |--------------------------------------------------------------------------
        | Jika data tidak ditemukan maka admin dikembalikan ke halaman
        | daftar pendaftaran dengan pesan error.
        |--------------------------------------------------------------------------
        */
        $pendaftaran = DB::table('pendaftarans')
            ->where('id', $id)
            ->first();

        if (!$pendaftaran) {
            return redirect()
                ->route('admin.pendaftaran')
                ->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        /*
        |--------------------------------------------------------------------------
        | Cek apakah siswa sudah pernah dimasukkan ke tabel siswas
        |--------------------------------------------------------------------------
        | Pencegahan data ganda dilakukan menggunakan kombinasi:
        | - nama
        | - tanggal lahir
        |--------------------------------------------------------------------------
        */
        $siswa = DB::table('siswas')
            ->where('nama', $pendaftaran->nama)
            ->where('tanggal_lahir', $pendaftaran->tanggal_lahir)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Jika siswa belum ada, buat data siswa baru
        |--------------------------------------------------------------------------
        */
        if (!$siswa) {

            /*
            |--------------------------------------------------------------------------
            | Simpan data pendaftaran ke tabel siswas
            |--------------------------------------------------------------------------
            | insertGetId() digunakan agar ID siswa yang baru dibuat dapat
            | langsung digunakan untuk membuat tagihan SPP pertama.
            |--------------------------------------------------------------------------
            */
            $siswaId = DB::table('siswas')->insertGetId([

                'nama' => $pendaftaran->nama,
                'tempat_lahir' => $pendaftaran->tempat_lahir,
                'tanggal_lahir' => $pendaftaran->tanggal_lahir,
                'jenis_kelamin' => $pendaftaran->jenis_kelamin,
                'kategori_latihan' => $pendaftaran->kategori_latihan,
                'no_hp' => $pendaftaran->no_hp,
                'nama_orang_tua' => $pendaftaran->nama_orang_tua,
                'alamat' => $pendaftaran->alamat,

                'foto_siswa' => $pendaftaran->foto_siswa,
                'surat_izin_ortu' => $pendaftaran->surat_izin_ortu,
                'dokumen_pendukung' => $pendaftaran->kartu_pelajar,

                'status_verifikasi' => 'Diterima',

                'tanggal_daftar' => now()->toDateString(),

                'created_at' => now(),
                'updated_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Membuat tagihan SPP pertama untuk siswa yang baru diterima
            |--------------------------------------------------------------------------
            | Relasi menggunakan siswa_id agar data pembayaran dapat
            | terhubung dengan data siswa.
            |--------------------------------------------------------------------------
            */
            DB::table('tagihan_spps')->insert([

                'siswa_id' => $siswaId,

                'bulan' => now()->translatedFormat('F'),
                'tahun' => now()->year,

                'nominal' => 150000,

                'status' => 'Belum Bayar',

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Update status pendaftaran menjadi diterima
        |--------------------------------------------------------------------------
        | Setelah data berhasil dipindahkan ke tabel siswa.
        |--------------------------------------------------------------------------
        */
        DB::table('pendaftarans')
            ->where('id', $id)
            ->update([
                'status' => 'diterima'
            ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect kembali ke halaman pendaftaran
        |--------------------------------------------------------------------------
        | Menampilkan pesan sukses kepada admin.
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.pendaftaran')
            ->with('success', 'Siswa berhasil diterima.');
    }
    /**
     * Tolak pendaftaran siswa
     */
    public function tolak($id)
    {
        DB::table('pendaftarans')
            ->where('id', $id)
            ->update([
                'status' => 'ditolak'
            ]);

        return redirect()
            ->route('admin.pendaftaran')
            ->with('success', 'Pendaftaran berhasil ditolak.');
    }
}