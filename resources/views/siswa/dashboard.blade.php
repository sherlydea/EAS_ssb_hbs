<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#fff8e7] text-[#1a0b0f] min-h-screen overflow-x-hidden">

    @include('siswa.partials.sidebar')

    @php
        $siswa = \DB::table('siswas')
            ->where('user_id', auth()->user()->id)
            ->first();

        $siswaId = $siswa->id ?? null;
        $namaSiswa = $siswa->nama ?? auth()->user()->name ?? 'Siswa';
        $kategori = $siswa->kategori_latihan ?? '-';

        $totalLatihan = $kategori !== '-'
            ? \DB::table('jadwal_latihans')->where('kategori_latihan', $kategori)->count()
            : 0;

        $totalTurnamen = $siswaId
            ? \DB::table('turnamen_siswas')->where('siswa_id', $siswaId)->count()
            : 0;

        $sppAktif = $siswaId
            ? \DB::table('tagihan_spps')
                ->where('siswa_id', $siswaId)
                ->whereIn('status', ['Belum Bayar', 'Ditolak'])
                ->orderBy('tahun', 'asc')
                ->orderBy('id', 'asc')
                ->first()
            : null;

        $totalJersey = $siswaId
            ? \DB::table('pesanan_jerseys')->where('siswa_id', $siswaId)->count()
            : 0;

        $totalAbsensi = $siswaId
            ? \DB::table('absensis')->where('siswa_id', $siswaId)->count()
            : 0;

        $totalHadir = $siswaId
            ? \DB::table('absensis')->where('siswa_id', $siswaId)->where('status', 'Hadir')->count()
            : 0;

        $persentaseHadir = $totalAbsensi > 0
            ? round(($totalHadir / $totalAbsensi) * 100)
            : 0;
    @endphp

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#7a1025] font-bold tracking-widest uppercase mb-3">
                    Portal Siswa
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight text-[#1a0b0f]">
                    Dashboard Siswa
                </h1>

                <p class="text-[#4b3a36] mt-3 max-w-2xl">
                    Ringkasan informasi utama siswa SSB HBS.
                </p>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-4 gap-5 mb-6">
                <div class="bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-6 shadow-lg">
                    <p class="text-[#6f5a55] text-sm mb-2">Nama Siswa</p>
                    <h2 class="text-xl font-black text-[#1a0b0f]">{{ $namaSiswa }}</h2>
                    <p class="text-[#7a1025] font-bold mt-2">{{ $kategori }}</p>
                </div>

                <div class="bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-6 shadow-lg">
                    <p class="text-[#6f5a55] text-sm mb-2">Jadwal Latihan</p>
                    <h2 class="text-4xl font-black text-[#7a1025]">{{ $totalLatihan }}</h2>
                </div>

                <div class="bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-6 shadow-lg">
                    <p class="text-[#6f5a55] text-sm mb-2">Turnamen Saya</p>
                    <h2 class="text-4xl font-black text-[#7a1025]">{{ $totalTurnamen }}</h2>
                </div>

                <div class="bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-6 shadow-lg">
                    <p class="text-[#6f5a55] text-sm mb-2">Kehadiran</p>
                    <h2 class="text-4xl font-black text-green-600">{{ $persentaseHadir }}%</h2>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

                <div class="lg:col-span-2 bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-7 shadow-lg">
                    <p class="text-[#7a1025] font-bold tracking-widest uppercase text-sm mb-3">
                        Informasi Utama
                    </p>

                    <h2 class="text-2xl font-black mb-6 text-[#1a0b0f]">
                        Ringkasan Aktivitas
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <a href="{{ route('siswa.jadwal-latihan') }}"
                           class="bg-[#7a1025] border border-[#600018] rounded-2xl p-5 hover:bg-[#600018] transition shadow-md">
                            <p class="text-[#d4af37] font-bold mb-2">Latihan Saya</p>
                            <p class="text-white/85 text-sm">Lihat jadwal latihan sesuai kategori.</p>
                        </a>

                        <a href="{{ route('siswa.jadwal-turnamen') }}"
                           class="bg-[#7a1025] border border-[#600018] rounded-2xl p-5 hover:bg-[#600018] transition shadow-md">
                            <p class="text-[#d4af37] font-bold mb-2">Turnamen Saya</p>
                            <p class="text-white/85 text-sm">Lihat turnamen dan status keikutsertaan.</p>
                        </a>

                        <a href="{{ route('siswa.jersey') }}"
                           class="bg-[#7a1025] border border-[#600018] rounded-2xl p-5 hover:bg-[#600018] transition shadow-md">
                            <p class="text-[#d4af37] font-bold mb-2">Jersey Saya</p>
                            <p class="text-white/85 text-sm">{{ $totalJersey }} pesanan jersey tercatat.</p>
                        </a>

                        <a href="{{ route('siswa.riwayat-absensi') }}"
                           class="bg-[#7a1025] border border-[#600018] rounded-2xl p-5 hover:bg-[#600018] transition shadow-md">
                            <p class="text-[#d4af37] font-bold mb-2">Absensi Saya</p>
                            <p class="text-white/85 text-sm">{{ $totalAbsensi }} data absensi tercatat.</p>
                        </a>
                    </div>
                </div>

                <div class="bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-7 shadow-lg">
                    <p class="text-[#7a1025] font-bold tracking-widest uppercase text-sm mb-3">
                        SPP Saya
                    </p>

                    <h2 class="text-2xl font-black mb-6 text-[#1a0b0f]">
                        Tagihan Aktif
                    </h2>

                    <div class="bg-[#fff4da] border border-[#7a1025]/20 rounded-2xl p-5 mb-5">
                        @if($sppAktif)
                            <p class="text-[#6f5a55] text-sm">
                                {{ $sppAktif->bulan }} {{ $sppAktif->tahun }}
                            </p>

                            <h3 class="text-3xl font-black mt-2 text-[#7a1025]">
                                Rp{{ number_format($sppAktif->nominal, 0, ',', '.') }}
                            </h3>

                            <span class="inline-block mt-4 bg-yellow-500/20 text-yellow-700 px-4 py-2 rounded-full text-sm font-bold">
                                {{ $sppAktif->status }}
                            </span>
                        @else
                            <p class="text-[#6f5a55] text-sm">
                                Status
                            </p>

                            <h3 class="text-2xl font-black mt-2 text-green-700">
                                Tidak Ada Tagihan
                            </h3>

                            <span class="inline-block mt-4 bg-green-500/15 text-green-700 px-4 py-2 rounded-full text-sm font-bold">
                                Aman
                            </span>
                        @endif
                    </div>

                    <a href="{{ route('siswa.pembayaran') }}"
                       class="block text-center bg-[#7a1025] text-white py-3 rounded-xl font-bold hover:bg-[#600018] transition">
                        Lihat SPP Saya
                    </a>
                </div>

            </section>

        </div>
    </main>

</body>
</html>