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
            'kategori_latihan' => 'required|in:U-10,U-12,U-15',
            'email' => 'required|email|unique:pendaftarans,email',
            'no_hp' => 'required|string|max:20',
            'nama_orang_tua' => 'nullable|string|max:255',
            'alamat' => 'required|string',
        ]);

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
            'status' => 'pending',
        ]);

        return redirect()
            ->route('pendaftaran.create')
            ->with('success', 'Pendaftaran berhasil dikirim. Silakan tunggu approve dari admin.');
    }
}