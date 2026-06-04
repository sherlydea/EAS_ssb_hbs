<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnamen Saya - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#080203] text-white min-h-screen overflow-x-hidden">

    @include('siswa.partials.sidebar')

    @php
        $siswa = \DB::table('siswas')
            ->where('user_id', auth()->user()->id)
            ->first();

        $kategori = $siswa->kategori_latihan ?? 'U-13';

        $turnamenPerKategori = [
            'U-10' => [
                [
                    'nama' => 'Festival Sepak Bola U-10',
                    'tanggal' => '20 Juli 2026',
                    'lokasi' => 'Lapangan SSB HBS Surabaya',
                    'status' => 'Terdaftar',
                    'keterangan' => 'Turnamen pengenalan kompetisi untuk siswa kategori U-10.',
                ],
            ],
            'U-13' => [
                [
                    'nama' => 'Surabaya Youth Cup U-13',
                    'tanggal' => '25 Juli 2026',
                    'lokasi' => 'Lapangan Thor Surabaya',
                    'status' => 'Terdaftar',
                    'keterangan' => 'Turnamen pembinaan untuk meningkatkan pengalaman bertanding siswa U-13.',
                ],
            ],
            'U-15' => [
                [
                    'nama' => 'Liga Pelajar U-15',
                    'tanggal' => '10 Agustus 2026',
                    'lokasi' => 'Gelora Bung Tomo Surabaya',
                    'status' => 'Menunggu Konfirmasi',
                    'keterangan' => 'Kompetisi antar sekolah sepak bola kategori U-15.',
                ],
            ],
            'U-18' => [
                [
                    'nama' => 'Piala Soeratin Internal Selection',
                    'tanggal' => '18 Agustus 2026',
                    'lokasi' => 'Lapangan PSSI Surabaya',
                    'status' => 'Seleksi',
                    'keterangan' => 'Seleksi turnamen untuk siswa kategori U-18 menuju kompetisi prestasi.',
                ],
            ],
        ];

        $turnamenSaya = $turnamenPerKategori[$kategori] ?? [];
    @endphp

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    Turnamen Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Jadwal Turnamen {{ $kategori }}
                </h1>

                <p class="text-white/60 mt-3 max-w-2xl">
                    Informasi turnamen yang sesuai dengan kategori latihan siswa yang sedang login.
                </p>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <div class="mb-7">
                        <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                            Turnamen Terdekat
                        </p>

                        <h2 class="text-3xl font-black">
                            Kategori {{ $kategori }}
                        </h2>

                        <p class="text-white/60 mt-2">
                            Daftar kegiatan turnamen berdasarkan kelompok usia siswa.
                        </p>
                    </div>

                    @if(count($turnamenSaya) > 0)
                        <div class="space-y-5">
                            @foreach($turnamenSaya as $turnamen)
                                <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-6 hover:bg-[#1a0608] transition">
                                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                        <div>
                                            <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                                                {{ $kategori }}
                                            </p>

                                            <h3 class="text-2xl font-black mb-3">
                                                {{ $turnamen['nama'] }}
                                            </h3>

                                            <div class="space-y-2 text-white/65 text-sm">
                                                <p>
                                                    <span class="text-white font-semibold">Tanggal:</span>
                                                    {{ $turnamen['tanggal'] }}
                                                </p>

                                                <p>
                                                    <span class="text-white font-semibold">Lokasi:</span>
                                                    {{ $turnamen['lokasi'] }}
                                                </p>

                                                <p>
                                                    <span class="text-white font-semibold">Keterangan:</span>
                                                    {{ $turnamen['keterangan'] }}
                                                </p>
                                            </div>
                                        </div>

                                        @if($turnamen['status'] === 'Terdaftar')
                                            <span class="w-fit bg-green-500/15 text-green-400 px-4 py-2 rounded-full text-sm font-bold">
                                                Terdaftar
                                            </span>
                                        @elseif($turnamen['status'] === 'Menunggu Konfirmasi')
                                            <span class="w-fit bg-yellow-500/15 text-yellow-300 px-4 py-2 rounded-full text-sm font-bold">
                                                Menunggu Konfirmasi
                                            </span>
                                        @else
                                            <span class="w-fit bg-[#d4af37]/15 text-[#d4af37] px-4 py-2 rounded-full text-sm font-bold">
                                                {{ $turnamen['status'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-6">
                            <p class="text-white/60">
                                Belum ada jadwal turnamen untuk kategori ini.
                            </p>
                        </div>
                    @endif
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                        Catatan
                    </p>

                    <h2 class="text-2xl font-black mb-5">
                        Informasi Turnamen
                    </h2>

                    <div class="space-y-4">
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">
                                Peserta Turnamen
                            </p>

                            <p class="text-white/55 text-sm leading-relaxed">
                                Turnamen ditampilkan sesuai kategori latihan siswa.
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">
                                Konfirmasi
                            </p>

                            <p class="text-white/55 text-sm leading-relaxed">
                                Status keikutsertaan turnamen akan diinformasikan melalui sistem.
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">
                                Informasi Tambahan
                            </p>

                            <p class="text-white/55 text-sm leading-relaxed">
                                Siswa wajib mengikuti arahan pelatih sebelum hari pertandingan.
                            </p>
                        </div>
                    </div>
                </div>

            </section>

            <section class="mt-6 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-5">
                    Ringkasan Turnamen Semua Kategori
                </p>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[850px] text-left">
                        <thead>
                            <tr class="border-b border-white/10 text-white/60">
                                <th class="py-4 px-4">Kategori</th>
                                <th class="py-4 px-4">Nama Turnamen</th>
                                <th class="py-4 px-4">Tanggal</th>
                                <th class="py-4 px-4">Lokasi</th>
                                <th class="py-4 px-4">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            @foreach($turnamenPerKategori as $key => $items)
                                @foreach($items as $item)
                                    <tr class="{{ $key == $kategori ? 'bg-[#1a0608]' : '' }} hover:bg-[#1a0608] transition">
                                        <td class="py-4 px-4 font-bold {{ $key == $kategori ? 'text-[#d4af37]' : 'text-white' }}">
                                            {{ $key }}
                                        </td>

                                        <td class="py-4 px-4 text-white/70">
                                            {{ $item['nama'] }}
                                        </td>

                                        <td class="py-4 px-4 text-white/70">
                                            {{ $item['tanggal'] }}
                                        </td>

                                        <td class="py-4 px-4 text-white/70">
                                            {{ $item['lokasi'] }}
                                        </td>

                                        <td class="py-4 px-4">
                                            @if($item['status'] === 'Terdaftar')
                                                <span class="bg-green-500/15 text-green-400 px-3 py-1.5 rounded-full text-xs font-bold">
                                                    Terdaftar
                                                </span>
                                            @elseif($item['status'] === 'Menunggu Konfirmasi')
                                                <span class="bg-yellow-500/15 text-yellow-300 px-3 py-1.5 rounded-full text-xs font-bold">
                                                    Menunggu
                                                </span>
                                            @else
                                                <span class="bg-[#d4af37]/15 text-[#d4af37] px-3 py-1.5 rounded-full text-xs font-bold">
                                                    {{ $item['status'] }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>

</body>
</html>