<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan Saya - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#080203] text-white min-h-screen overflow-x-hidden">

    @include('siswa.partials.sidebar')

    @php
        $siswa = \DB::table('siswas')
            ->where('user_id', auth()->user()->id)
            ->first();

        $kategori = $siswa->kategori_latihan ?? 'U-13';

        $jadwalPerKategori = [
            'U-10' => [
                'hari' => 'Sabtu',
                'jam' => '07.00 - 09.00 WIB',
                'materi' => 'Pengenalan sepak bola, kelincahan, koordinasi tubuh, dan teknik dasar mengontrol bola.',
                'pelatih' => 'Coach Andi',
                'lokasi' => 'Lapangan SSB HBS',
            ],
            'U-13' => [
                'hari' => 'Sabtu',
                'jam' => '15.00 - 17.00 WIB',
                'materi' => 'Pemantapan teknik individu, passing, dribbling, pengenalan posisi, dan kerja sama tim.',
                'pelatih' => 'Coach Budi',
                'lokasi' => 'Lapangan SSB HBS',
            ],
            'U-15' => [
                'hari' => 'Minggu',
                'jam' => '07.00 - 09.00 WIB',
                'materi' => 'Taktik menyerang dan bertahan, organisasi tim, finishing, serta penguatan fisik.',
                'pelatih' => 'Coach Rian',
                'lokasi' => 'Lapangan SSB HBS',
            ],
            'U-18' => [
                'hari' => 'Minggu',
                'jam' => '15.00 - 17.00 WIB',
                'materi' => 'Taktik tingkat lanjut, simulasi kompetisi, mental bertanding, dan persiapan turnamen.',
                'pelatih' => 'Coach Dimas',
                'lokasi' => 'Lapangan SSB HBS',
            ],
        ];

        $jadwalSaya = $jadwalPerKategori[$kategori] ?? $jadwalPerKategori['U-13'];
    @endphp

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    Latihan Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Jadwal Latihan {{ $kategori }}
                </h1>

                <p class="text-white/60 mt-3 max-w-2xl">
                    Jadwal latihan ini ditampilkan berdasarkan kategori latihan siswa yang sedang login.
                </p>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">

                    <div class="mb-7">
                        <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                            Jadwal Utama
                        </p>

                        <h2 class="text-3xl font-black">
                            {{ $jadwalSaya['hari'] }}
                        </h2>

                        <p class="text-white/60 mt-2">
                            {{ $jadwalSaya['jam'] }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">
                                Kategori
                            </p>

                            <p class="text-[#d4af37] text-2xl font-black">
                                {{ $kategori }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">
                                Pelatih
                            </p>

                            <p class="text-white font-bold">
                                {{ $jadwalSaya['pelatih'] }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">
                                Lokasi
                            </p>

                            <p class="text-white font-bold">
                                {{ $jadwalSaya['lokasi'] }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">
                                Status Jadwal
                            </p>

                            <p class="text-green-400 font-bold">
                                Aktif
                            </p>
                        </div>
                    </div>

                    <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                        <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                            Materi Latihan
                        </p>

                        <p class="text-white/70 leading-relaxed">
                            {{ $jadwalSaya['materi'] }}
                        </p>
                    </div>

                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">

                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                        Catatan
                    </p>

                    <h2 class="text-2xl font-black mb-5">
                        Informasi Latihan
                    </h2>

                    <div class="space-y-4">
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">
                                Datang Tepat Waktu
                            </p>

                            <p class="text-white/55 text-sm leading-relaxed">
                                Siswa diharapkan hadir minimal 15 menit sebelum latihan dimulai.
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">
                                Perlengkapan
                            </p>

                            <p class="text-white/55 text-sm leading-relaxed">
                                Gunakan sepatu bola, kaos latihan, botol minum, dan perlengkapan pribadi.
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">
                                Absensi
                            </p>

                            <p class="text-white/55 text-sm leading-relaxed">
                                Kehadiran latihan akan dicatat oleh pelatih atau admin.
                            </p>
                        </div>
                    </div>

                </div>

            </section>

            <section class="mt-6 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-5">
                    Ringkasan Jadwal Semua Kategori
                </p>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[700px] text-left">
                        <thead>
                            <tr class="border-b border-white/10 text-white/60">
                                <th class="py-4 px-4">Kategori</th>
                                <th class="py-4 px-4">Hari</th>
                                <th class="py-4 px-4">Jam</th>
                                <th class="py-4 px-4">Pelatih</th>
                                <th class="py-4 px-4">Lokasi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            @foreach($jadwalPerKategori as $key => $item)
                                <tr class="{{ $key == $kategori ? 'bg-[#1a0608]' : '' }} hover:bg-[#1a0608] transition">
                                    <td class="py-4 px-4 font-bold {{ $key == $kategori ? 'text-[#d4af37]' : 'text-white' }}">
                                        {{ $key }}
                                    </td>

                                    <td class="py-4 px-4 text-white/70">
                                        {{ $item['hari'] }}
                                    </td>

                                    <td class="py-4 px-4 text-white/70">
                                        {{ $item['jam'] }}
                                    </td>

                                    <td class="py-4 px-4 text-white/70">
                                        {{ $item['pelatih'] }}
                                    </td>

                                    <td class="py-4 px-4 text-white/70">
                                        {{ $item['lokasi'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>

</body>
</html>