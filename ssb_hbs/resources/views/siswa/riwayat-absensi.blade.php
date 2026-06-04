<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Saya - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#080203] text-white min-h-screen overflow-x-hidden">

    @include('siswa.partials.sidebar')

    @php
        $siswa = \DB::table('siswas')
            ->where('user_id', auth()->user()->id)
            ->first();

        $namaSiswa = $siswa->nama ?? auth()->user()->name ?? 'Siswa';
        $kategori = $siswa->kategori_latihan ?? '-';

        $riwayatAbsensi = [
            [
                'tanggal' => '01 Juni 2026',
                'hari' => 'Senin',
                'jam' => '15.00 - 17.00 WIB',
                'materi' => 'Dribbling dan kontrol bola',
                'status' => 'Hadir',
                'keterangan' => '-',
            ],
            [
                'tanggal' => '05 Juni 2026',
                'hari' => 'Jumat',
                'jam' => '15.00 - 17.00 WIB',
                'materi' => 'Passing dan kerja sama tim',
                'status' => 'Hadir',
                'keterangan' => '-',
            ],
            [
                'tanggal' => '08 Juni 2026',
                'hari' => 'Senin',
                'jam' => '15.00 - 17.00 WIB',
                'materi' => 'Finishing',
                'status' => 'Izin',
                'keterangan' => 'Sakit',
            ],
            [
                'tanggal' => '12 Juni 2026',
                'hari' => 'Jumat',
                'jam' => '15.00 - 17.00 WIB',
                'materi' => 'Simulasi pertandingan',
                'status' => 'Hadir',
                'keterangan' => '-',
            ],
        ];

        $totalLatihan = count($riwayatAbsensi);
        $totalHadir = collect($riwayatAbsensi)->where('status', 'Hadir')->count();
        $totalIzin = collect($riwayatAbsensi)->where('status', 'Izin')->count();
        $totalAlpa = collect($riwayatAbsensi)->where('status', 'Alpa')->count();
        $persentaseHadir = $totalLatihan > 0 ? round(($totalHadir / $totalLatihan) * 100) : 0;
    @endphp

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    Absensi Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Riwayat Kehadiran
                </h1>

                <p class="text-white/60 mt-3 max-w-2xl">
                    Informasi riwayat kehadiran latihan siswa SSB HBS berdasarkan data absensi.
                </p>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-4 gap-5 mb-6">
                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                    <p class="text-white/45 text-sm mb-2">Nama Siswa</p>
                    <h2 class="text-xl font-black">{{ $namaSiswa }}</h2>
                    <p class="text-[#d4af37] font-bold mt-2">{{ $kategori }}</p>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                    <p class="text-white/45 text-sm mb-2">Total Latihan</p>
                    <h2 class="text-4xl font-black text-[#d4af37]">{{ $totalLatihan }}</h2>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                    <p class="text-white/45 text-sm mb-2">Jumlah Hadir</p>
                    <h2 class="text-4xl font-black text-green-400">{{ $totalHadir }}</h2>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                    <p class="text-white/45 text-sm mb-2">Persentase Hadir</p>
                    <h2 class="text-4xl font-black text-[#d4af37]">{{ $persentaseHadir }}%</h2>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <div class="mb-6">
                        <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                            Daftar Absensi
                        </p>

                        <h2 class="text-2xl font-black">
                            Riwayat Latihan
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[850px] text-left">
                            <thead>
                                <tr class="border-b border-white/10 text-white/60">
                                    <th class="py-4 px-4">Tanggal</th>
                                    <th class="py-4 px-4">Hari</th>
                                    <th class="py-4 px-4">Jam</th>
                                    <th class="py-4 px-4">Materi</th>
                                    <th class="py-4 px-4">Status</th>
                                    <th class="py-4 px-4">Keterangan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-white/10">
                                @foreach($riwayatAbsensi as $item)
                                    <tr class="hover:bg-[#1a0608] transition">
                                        <td class="py-4 px-4 font-bold">
                                            {{ $item['tanggal'] }}
                                        </td>

                                        <td class="py-4 px-4 text-white/70">
                                            {{ $item['hari'] }}
                                        </td>

                                        <td class="py-4 px-4 text-white/70">
                                            {{ $item['jam'] }}
                                        </td>

                                        <td class="py-4 px-4 text-white/70">
                                            {{ $item['materi'] }}
                                        </td>

                                        <td class="py-4 px-4">
                                            @if($item['status'] === 'Hadir')
                                                <span class="bg-green-500/15 text-green-400 px-3 py-1.5 rounded-full text-xs font-bold">
                                                    Hadir
                                                </span>
                                            @elseif($item['status'] === 'Izin')
                                                <span class="bg-yellow-500/15 text-yellow-300 px-3 py-1.5 rounded-full text-xs font-bold">
                                                    Izin
                                                </span>
                                            @else
                                                <span class="bg-red-500/15 text-red-400 px-3 py-1.5 rounded-full text-xs font-bold">
                                                    Alpa
                                                </span>
                                            @endif
                                        </td>

                                        <td class="py-4 px-4 text-white/70">
                                            {{ $item['keterangan'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                        Ringkasan
                    </p>

                    <h2 class="text-2xl font-black mb-5">
                        Status Kehadiran
                    </h2>

                    <div class="space-y-4">
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Hadir</p>
                            <p class="text-green-400 text-2xl font-black">{{ $totalHadir }}x</p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Izin</p>
                            <p class="text-yellow-300 text-2xl font-black">{{ $totalIzin }}x</p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Alpa</p>
                            <p class="text-red-400 text-2xl font-black">{{ $totalAlpa }}x</p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">Catatan</p>
                            <p class="text-white/55 text-sm leading-relaxed">
                                Absensi dicatat oleh pelatih atau admin setiap kegiatan latihan berlangsung.
                            </p>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>

</body>
</html>