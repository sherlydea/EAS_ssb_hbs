<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#fff8e7] text-[#1a0b0f] min-h-screen overflow-x-hidden">

    @include('siswa.partials.sidebar')

    @php
        $siswa = \DB::table('siswas')
            ->where('user_id', auth()->id())
            ->first();
    @endphp

    <main class="pt-28 min-h-screen px-6 py-10">

        <div class="max-w-6xl mx-auto">

            {{-- Header --}}
            <section class="mb-10">

                <p class="text-[#7a1025] font-bold tracking-widest uppercase mb-3">
                    Portal Siswa
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight text-[#1a0b0f]">
                    Profil Saya
                </h1>

                <p class="text-[#6f5a55] mt-3 max-w-2xl">
                    Informasi data pribadi siswa yang tersimpan pada sistem SSB HBS.
                </p>

            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Card Profil --}}
                <div class="bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-7 shadow-lg">

                    <div class="w-36 h-36 mx-auto rounded-3xl bg-[#fff4da] border border-[#7a1025]/25 flex items-center justify-center mb-6">

                        <span class="text-[#7a1025] text-5xl font-black">
                            {{ strtoupper(substr($siswa->nama ?? auth()->user()->name ?? 'S',0,1)) }}
                        </span>

                    </div>

                    <h2 class="text-2xl font-black text-center text-[#1a0b0f]">
                        {{ $siswa->nama ?? auth()->user()->name ?? '-' }}
                    </h2>

                    <p class="text-[#7a1025] text-center font-bold mt-2">
                        {{ $siswa->kategori_latihan ?? '-' }}
                    </p>

                    <div class="mt-6 bg-[#fff4da] border border-[#7a1025]/20 rounded-2xl p-5 text-center">

                        <p class="text-[#6f5a55] text-sm">
                            Status Siswa
                        </p>

                        <p class="text-green-700 font-black mt-1">
                            Aktif
                        </p>

                    </div>

                </div>

                {{-- Informasi Pribadi --}}
                <div class="lg:col-span-2 bg-[#fffaf0] border border-[#7a1025]/25 rounded-3xl p-7 shadow-lg">

                    <p class="text-[#7a1025] font-bold tracking-widest uppercase text-sm mb-3">
                        Informasi Pribadi
                    </p>

                    <h2 class="text-2xl font-black mb-6 text-[#1a0b0f]">
                        Data Siswa
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div class="bg-[#fff4da] border border-[#7a1025]/20 rounded-2xl p-5">
                            <p class="text-[#6f5a55] text-sm mb-1">Nama Lengkap</p>
                            <p class="font-bold text-[#1a0b0f]">
                                {{ $siswa->nama ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#fff4da] border border-[#7a1025]/20 rounded-2xl p-5">
                            <p class="text-[#6f5a55] text-sm mb-1">Username</p>
                            <p class="font-bold text-[#1a0b0f]">
                                {{ auth()->user()->username ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#fff4da] border border-[#7a1025]/20 rounded-2xl p-5">
                            <p class="text-[#6f5a55] text-sm mb-1">Email</p>
                            <p class="font-bold text-[#1a0b0f]">
                                {{ auth()->user()->email ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#fff4da] border border-[#7a1025]/20 rounded-2xl p-5">
                            <p class="text-[#6f5a55] text-sm mb-1">Nomor HP</p>
                            <p class="font-bold text-[#1a0b0f]">
                                {{ $siswa->no_hp ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#fff4da] border border-[#7a1025]/20 rounded-2xl p-5">
                            <p class="text-[#6f5a55] text-sm mb-1">Tempat Lahir</p>
                            <p class="font-bold text-[#1a0b0f]">
                                {{ $siswa->tempat_lahir ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#fff4da] border border-[#7a1025]/20 rounded-2xl p-5">
                            <p class="text-[#6f5a55] text-sm mb-1">Tanggal Lahir</p>
                            <p class="font-bold text-[#1a0b0f]">
                                {{ $siswa->tanggal_lahir ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#fff4da] border border-[#7a1025]/20 rounded-2xl p-5">
                            <p class="text-[#6f5a55] text-sm mb-1">Jenis Kelamin</p>
                            <p class="font-bold text-[#1a0b0f]">
                                {{ $siswa->jenis_kelamin ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-[#fff4da] border border-[#7a1025]/20 rounded-2xl p-5">
                            <p class="text-[#6f5a55] text-sm mb-1">Kategori Latihan</p>
                            <p class="font-bold text-[#7a1025]">
                                {{ $siswa->kategori_latihan ?? '-' }}
                            </p>
                        </div>

                        <div class="md:col-span-2 bg-[#fff4da] border border-[#7a1025]/20 rounded-2xl p-5">
                            <p class="text-[#6f5a55] text-sm mb-1">
                                Nama Orang Tua / Wali
                            </p>

                            <p class="font-bold text-[#1a0b0f]">
                                {{ $siswa->nama_orang_tua ?? '-' }}
                            </p>
                        </div>

                        <div class="md:col-span-2 bg-[#fff4da] border border-[#7a1025]/20 rounded-2xl p-5">
                            <p class="text-[#6f5a55] text-sm mb-1">
                                Alamat
                            </p>

                            <p class="font-bold text-[#1a0b0f] leading-relaxed">
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