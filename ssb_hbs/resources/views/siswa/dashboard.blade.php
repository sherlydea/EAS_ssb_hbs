<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#080203] text-white min-h-screen overflow-x-hidden">

    @include('siswa.partials.sidebar')

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    Portal Siswa
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Dashboard Siswa
                </h1>

                <p class="text-white/60 mt-3 max-w-2xl">
                    Ringkasan informasi utama terkait jadwal dan pembayaran siswa SSB HBS.
                </p>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- INFORMASI JADWAL TERDEKAT -->
                <div class="lg:col-span-2 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <div class="mb-6">
                        <p class="text-[#d4af37] font-bold text-sm tracking-widest uppercase mb-2">
                            Informasi Jadwal Terdekat
                        </p>

                        <h2 class="text-2xl font-black">
                            Kegiatan Siswa
                        </h2>
                    </div>

                    <div class="space-y-5">

                        <!-- JADWAL LATIHAN -->
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <p class="text-[#d4af37] text-sm font-bold tracking-widest uppercase mb-2">
                                        Jadwal Latihan
                                    </p>

                                    <h3 class="font-bold text-xl">
                                        Sabtu, 15.00 WIB
                                    </h3>

                                    <p class="text-white/55 text-sm mt-1">
                                        Materi: Dribbling dan kontrol bola
                                    </p>
                                </div>

                                <a href="{{ url('/siswa/jadwal-latihan') }}"
                                   class="w-fit border border-[#d4af37] text-[#d4af37] px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-[#d4af37] hover:text-[#120608] transition">
                                    Lihat Jadwal
                                </a>
                            </div>
                        </div>

                        <!-- JADWAL TURNAMEN -->
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <p class="text-[#d4af37] text-sm font-bold tracking-widest uppercase mb-2">
                                        Jadwal Turnamen
                                    </p>

                                    <h3 class="font-bold text-xl">
                                        Surabaya Youth Cup
                                    </h3>

                                    <p class="text-white/55 text-sm mt-1">
                                        Tanggal: 15 Juli 2026
                                    </p>
                                </div>

                                <a href="{{ url('/siswa/jadwal-turnamen') }}"
                                   class="w-fit border border-[#d4af37] text-[#d4af37] px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-[#d4af37] hover:text-[#120608] transition">
                                    Lihat Turnamen
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- INFORMASI PEMBAYARAN -->
                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <p class="text-[#d4af37] font-bold text-sm tracking-widest uppercase mb-3">
                        Pembayaran
                    </p>

                    <h2 class="text-2xl font-black mb-6">
                        SPP Bulan Ini
                    </h2>

                    <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5 mb-5">
                        <p class="text-white/50 text-sm">
                            Tagihan
                        </p>

                        <h3 class="text-3xl font-black mt-2">
                            Rp150.000
                        </h3>

                        <span class="inline-block mt-4 bg-yellow-500/15 text-yellow-300 px-4 py-2 rounded-full text-sm font-bold">
                            Menunggu Konfirmasi
                        </span>
                    </div>

                    <a href="{{ url('/siswa/pembayaran') }}"
                       class="block text-center bg-[#d4af37] text-[#120608] py-3 rounded-xl font-bold hover:bg-[#e6c04a] transition">
                        Lihat Pembayaran
                    </a>
                </div>

            </section>

        </div>
    </main>

</body>
</html>