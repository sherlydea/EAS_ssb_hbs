<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Saya - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body{
            min-height:100%;
            overflow-y:auto;
        }
        .glass-card{
            background: linear-gradient(145deg, rgba(26,6,8,.95), rgba(12,3,5,.95));
            border: 1px solid rgba(212,175,55,.15);
            box-shadow: 0 20px 60px rgba(0,0,0,.45);
        }
    </style>
</head>

<body class="bg-[#f5f0e6] text-black min-h-screen overflow-x-hidden px-6 py-10">

@include('siswa.partials.sidebar')

@php
    $siswa = \DB::table('siswas')
        ->where('user_id', auth()->user()->id)
        ->first();

    $namaSiswa = $siswa->nama ?? auth()->user()->name ?? 'Siswa';
    $kategori = $siswa->kategori_latihan ?? '-';

    $totalLatihan = $riwayatAbsensi->count();
    $totalHadir = $riwayatAbsensi->where('status', 'Hadir')->count();
    $totalIzin = $riwayatAbsensi->where('status', 'Izin')->count();
    $totalAlpa = $riwayatAbsensi->where('status', 'Alpa')->count();

    $persentaseHadir = $totalLatihan > 0
        ? round(($totalHadir / $totalLatihan) * 100)
        : 0;

    function badgeAbsensiClass($status) {
        return match ($status) {
            'Hadir' => 'bg-green-500/15 text-green-600',
            'Izin' => 'bg-yellow-500/15 text-yellow-600',
            'Alpa' => 'bg-red-500/15 text-red-600',
            default => 'bg-white/10 text-black/60',
        };
    }
@endphp

<main class="pt-28 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <section class="mb-10">
            <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                Absensi Saya
            </p>

            <h1 class="text-4xl md:text-5xl font-black leading-tight">
                Riwayat Kehadiran
            </h1>

            <p class="text-black/60 mt-3 max-w-2xl">
                Riwayat absensi latihan siswa. Data absensi dicatat oleh pelatih atau admin.
            </p>
        </section>

        <!-- Ringkasan -->
        <section class="grid grid-cols-1 lg:grid-cols-4 gap-5 mb-6">
            <div class="bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                <p class="text-black/50 text-sm mb-2">Nama Siswa</p>
                <h2 class="text-xl font-black">{{ $namaSiswa }}</h2>
                <p class="text-[#d4af37] font-bold mt-2">{{ $kategori }}</p>
            </div>

            <div class="bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                <p class="text-black/50 text-sm mb-2">Total Latihan</p>
                <h2 class="text-4xl font-black text-[#d4af37]">{{ $totalLatihan }}</h2>
            </div>

            <div class="bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                <p class="text-black/50 text-sm mb-2">Jumlah Hadir</p>
                <h2 class="text-4xl font-black text-green-600">{{ $totalHadir }}</h2>
            </div>

            <div class="bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                <p class="text-black/50 text-sm mb-2">Persentase Hadir</p>
                <h2 class="text-4xl font-black text-[#d4af37]">{{ $persentaseHadir }}%</h2>
            </div>
        </section>

        <!-- Daftar Absensi -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                <div class="mb-6">
                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                        Daftar Absensi
                    </p>

                    <h2 class="text-2xl font-black">
                        Riwayat Latihan
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[750px] text-left">
                        <thead>
                            <tr class="border-b border-[#4e1218]/25 text-black/60">
                                <th class="py-4 px-4">Tanggal</th>
                                <th class="py-4 px-4">Jadwal Latihan</th>
                                <th class="py-4 px-4">Status</th>
                                <th class="py-4 px-4">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#4e1218]/25">
                            @forelse($riwayatAbsensi as $item)
                                <tr class="hover:bg-[#fff3e8]/20 transition">
                                    <td class="py-4 px-4 font-bold">
                                        {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-' }}
                                    </td>

                                    <td class="py-4 px-4 text-black/70">
                                        @if(isset($item->jadwal_latihan_id) && $item->jadwal_latihan_id)
                                            Jadwal #{{ $item->jadwal_latihan_id }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="py-4 px-4">
                                        <span class="{{ badgeAbsensiClass($item->status) }} px-3 py-1.5 rounded-full text-xs font-bold">
                                            {{ $item->status }}
                                        </span>
                                    </td>

                                    <td class="py-4 px-4 text-black/70">
                                        {{ $item->keterangan ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 px-4 text-center text-black/60">
                                        Belum ada data absensi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                    Ringkasan
                </p>

                <h2 class="text-2xl font-black mb-5">
                    Status Kehadiran
                </h2>

                <div class="space-y-4">
                    <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                        <p class="text-black/50 text-sm mb-1">Hadir</p>
                        <p class="text-green-600 text-2xl font-black">{{ $totalHadir }}x</p>
                    </div>

                    <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                        <p class="text-black/50 text-sm mb-1">Izin</p>
                        <p class="text-yellow-600 text-2xl font-black">{{ $totalIzin }}x</p>
                    </div>

                    <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                        <p class="text-black/50 text-sm mb-1">Alpa</p>
                        <p class="text-red-600 text-2xl font-black">{{ $totalAlpa }}x</p>
                    </div>

                    <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                        <p class="font-bold mb-1">Catatan</p>
                        <p class="text-black/60 text-sm leading-relaxed">
                            Siswa hanya dapat melihat riwayat absensi. Pengisian absensi dilakukan oleh pelatih atau admin.
                        </p>
                    </div>
                </div>
            </div>

        </section>

    </div>
</main>

</body>
</html>