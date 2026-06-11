<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesananJersey;

class AdminJerseyController extends Controller
{
    /**
     * Menampilkan daftar seluruh pesanan jersey menggunakan Eloquent ORM.
     */
    public function index()
    {
        // Mengambil data pesanan jersey lengkap dengan relasi data siswanya
        $pesanan = PesananJersey::with('siswa')->latest()->get();
        return view('admin.jersey.index', compact('pesanan'));
    }

    /**
     * Admin klik Terima: Mengonfirmasi pembayaran dan langsung melempar ke status Diproses (Produksi).
     */
    public function terima($id)
    {
        $pesanan = PesananJersey::findOrFail($id);
        $pesanan->status = 'Diproses';
        $pesanan->save();

        return back()->with('success', 'Pesanan berhasil diterima dan langsung masuk tahap produksi.');
    }

    /**
     * Admin klik Tolak: Menolak berkas bukti transfer pembayaran awal.
     */
    public function tolak($id)
    {
        $pesanan = PesananJersey::findOrFail($id);
        $pesanan->status = 'Ditolak';
        $pesanan->save();

        return back()->with('success', 'Bukti pembayaran transfer jersey ditolak.');
    }

    /**
     * Admin klik Selesai: Menyatakan konveksi jersey selesai dan siap didistribusikan.
     */
    public function selesai($id)
    {
        $pesanan = PesananJersey::findOrFail($id);
        $pesanan->status = 'Selesai';
        $pesanan->save();

        return back()->with('success', 'Produksi jersey selesai! Atribut siap diambil oleh siswa.');
    }
}