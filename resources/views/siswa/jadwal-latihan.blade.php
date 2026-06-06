<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan Saya - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#fff8e7] text-[#1a0b0f] min-h-screen overflow-x-hidden">

    @include('siswa.partials.sidebar')

    @php
        $namaSiswa = $siswa->nama ?? auth()->user()->name ?? 'Siswa';
        $kategori = $siswa->kategori_latihan ?? '-';
        $totalJadwal = $riwayatLatihan->count();
    @endphp

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#7a1025] font-bold tracking-widest uppercase mb-3">
                    Portal Siswa
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight text-[#1a0b0f]">
                    Latihan Saya
                </h1>

                <p class="text-[#6f5a55] mt-3 max-w-2xl">
                    Jadwal latihan yang ditampilkan sesuai kategori latihan siswa.
                </p>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
                <div class="bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-6 shadow-lg">
                    <p class="text-[#6f5a55] text-sm mb-2">Nama Siswa</p>
                    <h2 class="text-xl font-black text-[#1a0b0f]">{{ $namaSiswa }}</h2>
                    <p class="text-[#7a1025] font-bold mt-2">{{ $kategori }}</p>
                </div>

                <div class="bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-6 shadow-lg">
                    <p class="text-[#6f5a55] text-sm mb-2">Total Jadwal</p>
                    <h2 class="text-4xl font-black text-[#7a1025]">{{ $totalJadwal }}</h2>
                </div>

                <div class="bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-6 shadow-lg">
                    <p class="text-[#6f5a55] text-sm mb-2">Status</p>
                    <h2 class="text-2xl font-black text-green-700">Aktif</h2>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-7 shadow-lg">
                    <div class="mb-6">
                        <p class="text-[#7a1025] font-bold tracking-widest uppercase text-sm mb-3">
                            Daftar Jadwal
                        </p>

                        <h2 class="text-2xl font-black text-[#1a0b0f]">
                            Jadwal Latihan Kategori {{ $kategori }}
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[750px] text-left">
                            <thead>
                                <tr class="border-b border-[#7a1025]/20 text-[#6f5a55]">
                                    <th class="py-4 px-4">Hari</th>
                                    <th class="py-4 px-4">Jam</th>
                                    <th class="py-4 px-4">Kategori</th>
                                    <th class="py-4 px-4">Lokasi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-[#7a1025]/15">
                                @forelse($riwayatLatihan as $item)
                                    <tr class="hover:bg-[#fff4da] transition">
                                        <td class="py-4 px-4 font-bold text-[#7a1025]">
                                            {{ $item->hari ?? '-' }}
                                        </td>

                                        <td class="py-4 px-4 text-[#4b3a36]">
                                            {{ $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '-' }}
                                            -
                                            {{ $item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-' }}
                                            WIB
                                        </td>

                                        <td class="py-4 px-4 text-[#4b3a36]">
                                            {{ $item->kategori_latihan ?? '-' }}
                                        </td>

                                        <td class="py-4 px-4 text-[#4b3a36]">
                                            {{ $item->lokasi ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 px-4 text-center text-[#6f5a55]">
                                            Belum ada jadwal latihan untuk kategori ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-7 shadow-lg">
                    <p class="text-[#7a1025] font-bold tracking-widest uppercase text-sm mb-3">
                        Informasi
                    </p>

                    <h2 class="text-2xl font-black mb-5 text-[#1a0b0f]">
                        Catatan Latihan
                    </h2>

                    <div class="space-y-4">
                        <div class="bg-[#7a1025] border border-[#600018] rounded-2xl p-5 shadow-md">
                            <p class="font-bold mb-1 text-[#d4af37]">Sesuai Kategori</p>
                            <p class="text-white/85 text-sm leading-relaxed">
                                Jadwal ditampilkan berdasarkan kategori latihan siswa yang sedang login.
                            </p>
                        </div>

                        <div class="bg-[#7a1025] border border-[#600018] rounded-2xl p-5 shadow-md">
                            <p class="font-bold mb-1 text-[#d4af37]">Absensi</p>
                            <p class="text-white/85 text-sm leading-relaxed">
                                Kehadiran latihan dicatat oleh pelatih atau admin melalui menu absensi.
                            </p>
                        </div>

                        <div class="bg-[#7a1025] border border-[#600018] rounded-2xl p-5 shadow-md">
                            <p class="font-bold mb-1 text-[#d4af37]">Perubahan Jadwal</p>
                            <p class="text-white/85 text-sm leading-relaxed">
                                Jika ada perubahan jadwal, siswa akan mengikuti jadwal terbaru dari pelatih/admin.
                            </p>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>

</body>
</html>