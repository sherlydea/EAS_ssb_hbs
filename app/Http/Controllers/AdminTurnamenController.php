<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTurnamenController extends Controller
{
    /**
     * Menampilkan daftar turnamen dengan fitur pencarian dan filter status.
     */
    public function index(Request $request)
    {
        $query = DB::table('turnamens');

        // filter by name
        if ($request->filled('search')) {
            $query->where('nama_turnamen', 'like', '%'.$request->search.'%');
        }

        // filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $turnamens = $query->orderBy('tanggal', 'desc')->get();

        return view('admin.turnamen.index', compact('turnamens'));
    }

    /**
     * Menampilkan form untuk membuat turnamen baru.
     */
    public function create()
    {
        return view('admin.turnamen.create');
    }

    /**
     * Menyimpan data turnamen baru ke database menggunakan Query Builder.
     */
    public function store(Request $request)
    {
        // Perbaikan: Validasi status disesuaikan dengan opsi pada form input create
        $request->validate([
            'nama_turnamen' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:Menunggu,Terdaftar,Selesai',
        ]);

        DB::table('turnamens')->insert([
            'nama_turnamen' => $request->nama_turnamen,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.turnamen.index')
            ->with('success', 'Turnamen berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data turnamen tertentu.
     */
    public function edit($id)
    {
        $turnamen = DB::table('turnamens')
            ->where('id', $id)
            ->first();

        // Pengaman: Jika ID turnamen tidak ditemukan di database
        if (!$turnamen) {
            return redirect()->route('admin.turnamen.index')
                ->with('error', 'Data turnamen tidak ditemukan.');
        }

        return view('admin.turnamen.edit', compact('turnamen'));
    }

    /**
     * Memperbarui data turnamen di database menggunakan Query Builder.
     */
    public function update(Request $request, $id)
    {
        // Perbaikan: Validasi status diperketat agar sesuai dengan opsi pada form input edit
        $request->validate([
            'nama_turnamen' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:Menunggu,Terdaftar,Selesai'
        ]);

        DB::table('turnamens')
            ->where('id', $id)
            ->update([
                'nama_turnamen' => $request->nama_turnamen,
                'tanggal' => $request->tanggal,
                'lokasi' => $request->lokasi,
                'status' => $request->status,
                'updated_at' => now()
            ]);

        return redirect()
            ->route('admin.turnamen.index')
            ->with('success', 'Turnamen berhasil diperbarui.');
    }

    /**
     * Menghapus data turnamen dari database menggunakan Query Builder.
     */
    public function destroy($id)
    {
        DB::table('turnamens')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('admin.turnamen.index')
            ->with('success', 'Turnamen berhasil dihapus.');
    }
}