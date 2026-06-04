<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#080203] text-white min-h-screen overflow-x-hidden">

    @include('siswa.partials.sidebar')

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    Profil Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Data Siswa
                </h1>

                <p class="text-white/60 mt-3 max-w-2xl">
                    Informasi data diri siswa yang tersimpan pada sistem SSB HBS.
                </p>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <div class="w-36 h-36 mx-auto rounded-3xl bg-[#0f0304] border border-[#4e1218] flex items-center justify-center mb-6">
                        <span class="text-[#d4af37] text-4xl font-black">
                            {{ strtoupper(substr($siswa->nama ?? auth()->user()->name ?? 'S', 0, 1)) }}
                        </span>
                    </div>

                    <h2 class="text-2xl font-black text-center">
                        {{ $siswa->nama ?? auth()->user()->name ?? '-' }}
                    </h2>

                    <p class="text-[#d4af37] text-center font-bold mt-2">
                        {{ $siswa->kategori_latihan ?? '-' }}
                    </p>

                    <div class="mt-6 bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                        <p class="text-white/50 text-sm">Status Siswa</p>
                        <p class="text-green-400 font-bold mt-1">Aktif</p>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-6">
                        Informasi Pribadi
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Nama Lengkap</p>
                            <p class="font-bold">
                                {{ $siswa->nama ?? auth()->user()->name ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Email</p>
                            <p class="font-bold">
                                {{ auth()->user()->email ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Tempat Lahir</p>
                            <p class="font-bold">
                                {{ $siswa->tempat_lahir ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Tanggal Lahir</p>
                            <p class="font-bold">
                                {{ $siswa->tanggal_lahir ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Jenis Kelamin</p>
                            <p class="font-bold">
                                {{ $siswa->jenis_kelamin ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Kategori Latihan</p>
                            <p class="font-bold text-[#d4af37]">
                                {{ $siswa->kategori_latihan ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Nomor HP / WhatsApp</p>
                            <p class="font-bold">
                                {{ $siswa->no_hp ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Nama Orang Tua / Wali</p>
                            <p class="font-bold">
                                {{ $siswa->nama_orang_tua ?? '-' }}
                            </p>
                        </div>

                        <div class="md:col-span-2 bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Alamat</p>
                            <p class="font-bold leading-relaxed">
                                {{ $siswa->alamat ?? '-' }}
                            </p>
                        </div>

                    </div>
                </div>

            </section>

        </div>
    </main>

</body>
</html>