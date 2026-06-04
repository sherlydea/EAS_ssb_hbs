<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Saya - SSB HBS</title>

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

        $tagihanBulanIni = [
            'bulan' => 'Juni 2026',
            'jenis' => 'SPP Bulanan',
            'nominal' => 150000,
            'status' => 'Menunggu Konfirmasi',
            'bukti' => 'bukti_spp_juni.jpg',
            'tanggal_upload' => '04 Juni 2026',
        ];

        $riwayatPembayaran = [
            [
                'bulan' => 'Mei 2026',
                'jenis' => 'SPP Bulanan',
                'nominal' => 150000,
                'status' => 'Lunas',
                'tanggal' => '10 Mei 2026',
            ],
            [
                'bulan' => 'April 2026',
                'jenis' => 'SPP Bulanan',
                'nominal' => 150000,
                'status' => 'Lunas',
                'tanggal' => '08 April 2026',
            ],
            [
                'bulan' => 'Maret 2026',
                'jenis' => 'SPP Bulanan',
                'nominal' => 150000,
                'status' => 'Lunas',
                'tanggal' => '09 Maret 2026',
            ],
        ];
    @endphp

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    Pembayaran Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Tagihan & Riwayat SPP
                </h1>

                <p class="text-white/60 mt-3 max-w-2xl">
                    Informasi pembayaran siswa, status konfirmasi, dan riwayat pembayaran SPP.
                </p>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- TAGIHAN BULAN INI -->
                <div class="lg:col-span-2 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-5 mb-7">
                        <div>
                            <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                                Tagihan Aktif
                            </p>

                            <h2 class="text-3xl font-black">
                                {{ $tagihanBulanIni['jenis'] }}
                            </h2>

                            <p class="text-white/55 mt-2">
                                Periode {{ $tagihanBulanIni['bulan'] }}
                            </p>
                        </div>

                        <span class="w-fit bg-yellow-500/15 text-yellow-300 px-4 py-2 rounded-full text-sm font-bold">
                            {{ $tagihanBulanIni['status'] }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">
                                Nama Siswa
                            </p>

                            <p class="font-bold">
                                {{ $namaSiswa }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">
                                Kategori
                            </p>

                            <p class="font-bold text-[#d4af37]">
                                {{ $kategori }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">
                                Nominal Tagihan
                            </p>

                            <p class="text-3xl font-black">
                                Rp{{ number_format($tagihanBulanIni['nominal'], 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">
                                Tanggal Upload Bukti
                            </p>

                            <p class="font-bold">
                                {{ $tagihanBulanIni['tanggal_upload'] }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5 mb-6">
                        <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                            Upload Bukti Pembayaran
                        </p>

                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                <div class="md:col-span-2">
                                    <label class="block text-white/60 text-sm mb-2">
                                        Pilih file bukti transfer
                                    </label>

                                    <input
                                        type="file"
                                        name="bukti_pembayaran"
                                        class="w-full bg-[#140506] border border-[#4e1218] rounded-xl p-3 text-white file:bg-[#d4af37] file:text-[#120608] file:border-0 file:px-4 file:py-2 file:rounded-lg file:font-bold"
                                    >
                                </div>

                                <button
                                    type="submit"
                                    class="w-full bg-[#d4af37] text-[#120608] py-3 rounded-xl font-bold hover:bg-[#e6c04a] transition"
                                >
                                    Upload Bukti
                                </button>
                            </div>
                        </form>

                        <p class="text-white/45 text-sm mt-4 leading-relaxed">
                            Setelah bukti pembayaran dikirim, status akan menjadi
                            <span class="text-yellow-300 font-bold">Menunggu Konfirmasi</span>
                            sampai admin melakukan pengecekan.
                        </p>
                    </div>

                    <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-2xl p-5">
                        <p class="text-yellow-300 font-bold mb-2">
                            Catatan Pembayaran
                        </p>

                        <p class="text-white/60 text-sm leading-relaxed">
                            Pembayaran SPP dilakukan setiap bulan. Siswa tidak akan melihat tagihan baru sampai admin membuat tagihan periode berikutnya.
                        </p>
                    </div>
                </div>

                <!-- RINGKASAN -->
                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                        Ringkasan
                    </p>

                    <h2 class="text-2xl font-black mb-5">
                        Status Pembayaran
                    </h2>

                    <div class="space-y-4">
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">
                                SPP Bulan Ini
                            </p>

                            <p class="font-bold">
                                {{ $tagihanBulanIni['bulan'] }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">
                                Nominal
                            </p>

                            <p class="text-2xl font-black text-[#d4af37]">
                                Rp{{ number_format($tagihanBulanIni['nominal'], 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">
                                Status
                            </p>

                            <p class="text-yellow-300 font-bold">
                                {{ $tagihanBulanIni['status'] }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">
                                Bukti
                            </p>

                            <p class="text-white/70 font-bold">
                                {{ $tagihanBulanIni['bukti'] }}
                            </p>
                        </div>
                    </div>
                </div>

            </section>

            <!-- RIWAYAT PEMBAYARAN -->
            <section class="mt-6 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                            Riwayat Pembayaran
                        </p>

                        <h2 class="text-2xl font-black">
                            Pembayaran Sebelumnya
                        </h2>
                    </div>

                    <span class="w-fit bg-green-500/15 text-green-400 px-4 py-2 rounded-full text-sm font-bold">
                        {{ count($riwayatPembayaran) }} Pembayaran Lunas
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[800px] text-left">
                        <thead>
                            <tr class="border-b border-white/10 text-white/60">
                                <th class="py-4 px-4">Periode</th>
                                <th class="py-4 px-4">Jenis Pembayaran</th>
                                <th class="py-4 px-4">Nominal</th>
                                <th class="py-4 px-4">Tanggal Bayar</th>
                                <th class="py-4 px-4">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            @foreach($riwayatPembayaran as $item)
                                <tr class="hover:bg-[#1a0608] transition">
                                    <td class="py-4 px-4 font-bold">
                                        {{ $item['bulan'] }}
                                    </td>

                                    <td class="py-4 px-4 text-white/70">
                                        {{ $item['jenis'] }}
                                    </td>

                                    <td class="py-4 px-4 text-white/70">
                                        Rp{{ number_format($item['nominal'], 0, ',', '.') }}
                                    </td>

                                    <td class="py-4 px-4 text-white/70">
                                        {{ $item['tanggal'] }}
                                    </td>

                                    <td class="py-4 px-4">
                                        <span class="bg-green-500/15 text-green-400 px-3 py-1.5 rounded-full text-xs font-bold">
                                            {{ $item['status'] }}
                                        </span>
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