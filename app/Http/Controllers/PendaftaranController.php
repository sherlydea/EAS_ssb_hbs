<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;

class PendaftaranController extends Controller
{

    public function create()
    {
        return view('public.pendaftaran');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kategori_latihan' => 'required|in:U-10,U-13,U-15,U-18',
            'email' => 'required|email|unique:pendaftarans,email',
            'no_hp' => 'required|string|max:20',
            'nama_orang_tua' => 'required|string|max:255',
            'alamat' => 'required|string',
            'foto_siswa' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'surat_izin_ortu' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_pelajar' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $fotoSiswa = $request
            ->file('foto_siswa')
            ->store('pendaftaran/foto', 'public');

        $suratIzin = $request
            ->file('surat_izin_ortu')
            ->store('pendaftaran/surat', 'public');

        $kartuPelajar = $request
            ->file('kartu_pelajar')
            ->store('pendaftaran/dokumen', 'public');

        Pendaftaran::create([
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kategori_latihan' => $request->kategori_latihan,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'nama_orang_tua' => $request->nama_orang_tua,
            'alamat' => $request->alamat,
            'foto_siswa' => $fotoSiswa,
            'surat_izin_ortu' => $suratIzin,
            'kartu_pelajar' => $kartuPelajar,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('pendaftaran.create')
            ->with('success', 'Pendaftaran berhasil dikirim. Silakan tunggu approve dari admin.');
    }
}