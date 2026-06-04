<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Jersey - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#080203] text-white min-h-screen overflow-x-hidden">

    @include('siswa.partials.sidebar')

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    Jersey Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Pemesanan Jersey
                </h1>

                <p class="text-white/60 mt-3 max-w-2xl">
                    Pilih tipe jersey, ukuran, nama punggung, dan nomor punggung sesuai kebutuhan siswa.
                </p>
            </section>

            @if(session('success'))
                <div class="bg-green-500/15 text-green-300 border border-green-500/30 p-4 rounded-2xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500/15 text-red-300 border border-red-500/30 p-4 rounded-2xl mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <div class="mb-6">
                        <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                            Daftar Jersey
                        </p>

                        <h2 class="text-2xl font-black">
                            Pilihan Jersey SSB HBS
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[650px] text-left">
                            <thead>
                                <tr class="border-b border-white/10 text-white/60">
                                    <th class="py-4 px-4">Tipe Jersey</th>
                                    <th class="py-4 px-4">Harga</th>
                                    <th class="py-4 px-4">Keterangan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-white/10">
                                <tr class="hover:bg-[#1a0608] transition">
                                    <td class="py-4 px-4 font-bold text-[#d4af37]">Home</td>
                                    <td class="py-4 px-4 text-white/70">Rp120.000</td>
                                    <td class="py-4 px-4 text-white/70">Jersey utama SSB HBS</td>
                                </tr>

                                <tr class="hover:bg-[#1a0608] transition">
                                    <td class="py-4 px-4 font-bold text-[#d4af37]">Away</td>
                                    <td class="py-4 px-4 text-white/70">Rp120.000</td>
                                    <td class="py-4 px-4 text-white/70">Jersey tandang SSB HBS</td>
                                </tr>

                                <tr class="hover:bg-[#1a0608] transition">
                                    <td class="py-4 px-4 font-bold text-[#d4af37]">Training</td>
                                    <td class="py-4 px-4 text-white/70">Rp100.000</td>
                                    <td class="py-4 px-4 text-white/70">Jersey latihan siswa</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                        Catatan
                    </p>

                    <h2 class="text-2xl font-black mb-5">
                        Informasi Jersey
                    </h2>

                    <div class="space-y-4">
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">Tipe Jersey</p>
                            <p class="text-white/55 text-sm leading-relaxed">
                                Home, Away, dan Training dapat dipilih sesuai kebutuhan siswa.
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">Nama & Nomor</p>
                            <p class="text-white/55 text-sm leading-relaxed">
                                Nama punggung dan nomor punggung bersifat opsional.
                            </p>
                        </div>
                    </div>
                </div>

            </section>

            <section class="mt-6 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                <div class="mb-6">
                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                        Form Pesan Jersey
                    </p>

                    <h2 class="text-2xl font-black">
                        Lengkapi Data Pemesanan
                    </h2>
                </div>

                <form action="{{ route('siswa.jersey.pesan') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-white/70 font-semibold mb-2">
                                Tipe Jersey
                            </label>

                            <select
                                name="tipe_jersey"
                                class="w-full bg-[#0f0304] border border-[#4e1218] rounded-xl p-3 text-white focus:outline-none focus:border-[#d4af37] focus:ring-2 focus:ring-[#d4af37]/20"
                                required
                            >
                                <option value="">-- Pilih Tipe Jersey --</option>
                                <option value="Home">Home - Rp120.000</option>
                                <option value="Away">Away - Rp120.000</option>
                                <option value="Training">Training - Rp100.000</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-white/70 font-semibold mb-2">
                                Ukuran
                            </label>

                            <select
                                name="ukuran"
                                class="w-full bg-[#0f0304] border border-[#4e1218] rounded-xl p-3 text-white focus:outline-none focus:border-[#d4af37] focus:ring-2 focus:ring-[#d4af37]/20"
                                required
                            >
                                <option value="">-- Pilih Ukuran --</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-white/70 font-semibold mb-2">
                                Nama Punggung
                            </label>

                            <input
                                type="text"
                                name="nama_punggung"
                                class="w-full bg-[#0f0304] border border-[#4e1218] rounded-xl p-3 text-white placeholder-white/35 focus:outline-none focus:border-[#d4af37] focus:ring-2 focus:ring-[#d4af37]/20"
                                placeholder="Contoh: SHERLY"
                            >
                        </div>

                        <div>
                            <label class="block text-white/70 font-semibold mb-2">
                                Nomor Punggung
                            </label>

                            <input
                                type="number"
                                name="nomor_punggung"
                                class="w-full bg-[#0f0304] border border-[#4e1218] rounded-xl p-3 text-white placeholder-white/35 focus:outline-none focus:border-[#d4af37] focus:ring-2 focus:ring-[#d4af37]/20"
                                placeholder="Contoh: 10"
                                min="1"
                                max="99"
                            >
                        </div>
                    </div>

                    <div class="mt-7">
                        <button
                            type="submit"
                            class="bg-[#d4af37] text-[#120608] px-8 py-3 rounded-xl font-bold hover:bg-[#e6c04a] transition"
                        >
                            Pesan Jersey
                        </button>
                    </div>
                </form>
            </section>

        </div>
    </main>

</body>
</html>