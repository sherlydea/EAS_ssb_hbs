<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body {
            min-height: 100%;
            overflow-y: auto;
        }

        .glass-card {
            background: linear-gradient(
                145deg,
                rgba(26, 6, 8, 0.95),
                rgba(12, 3, 5, 0.95)
            );
            border: 1px solid rgba(212, 175, 55, 0.15);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.45);
        }
    </style>
</head>

<body class="bg-[#080203] min-h-screen py-10 px-4 overflow-y-auto relative">

    <div class="absolute top-20 left-20 w-80 h-80 bg-[#8d001f]/20 blur-3xl rounded-full"></div>
    <div class="absolute bottom-20 right-20 w-80 h-80 bg-[#d4af37]/10 blur-3xl rounded-full"></div>

    <div class="relative z-10 w-full max-w-4xl mx-auto">

        <div class="text-center mb-8">
            <h1 class="text-5xl font-black text-white">
                SSB <span class="text-[#d4af37]">HBS</span>
            </h1>

            <p class="text-white/50 mt-2">
                Sistem Informasi Sekolah Sepak Bola
            </p>
        </div>

        <div class="glass-card rounded-3xl p-8">

            <div class="text-center mb-8">
                <h1 class="text-4xl font-black text-[#d4af37]">
                    Form Pendaftaran Siswa
                </h1>

                <p class="text-white/60 mt-2">
                    Silakan isi data berikut untuk mendaftar sebagai siswa SSB HBS.
                </p>
            </div>

            @if(session('success'))
                <div class="bg-green-500/20 border border-green-500 text-green-300 p-3 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500 text-red-300 p-3 rounded-xl mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-white/80">
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama') }}"
                            class="w-full bg-[#0f0304] border border-[#4e1218] p-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-[#d4af37]/20 focus:border-[#d4af37]"
                            placeholder="Masukkan nama lengkap"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-white/80">
                            Tempat Lahir
                        </label>

                        <input
                            type="text"
                            name="tempat_lahir"
                            value="{{ old('tempat_lahir') }}"
                            class="w-full bg-[#0f0304] border border-[#4e1218] p-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-[#d4af37]/20 focus:border-[#d4af37]"
                            placeholder="Contoh: Surabaya"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-white/80">
                            Tanggal Lahir
                        </label>

                        <input
                            type="date"
                            name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}"
                            class="w-full bg-[#0f0304] border border-[#4e1218] p-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-[#d4af37]/20 focus:border-[#d4af37]"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-white/80">
                            Jenis Kelamin
                        </label>

                        <select
                            name="jenis_kelamin"
                            class="w-full bg-[#0f0304] border border-[#4e1218] p-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-[#d4af37]/20 focus:border-[#d4af37]"
                            required
                        >
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-white/80">
                            Kategori Latihan
                        </label>

                        <select
                            name="kategori_latihan"
                            class="w-full bg-[#0f0304] border border-[#4e1218] p-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-[#d4af37]/20 focus:border-[#d4af37]"
                            required
                        >
                            <option value="">Pilih Kategori</option>
                            <option value="U-10" {{ old('kategori_latihan') == 'U-10' ? 'selected' : '' }}>U-10</option>
                            <option value="U-12" {{ old('kategori_latihan') == 'U-12' ? 'selected' : '' }}>U-12</option>
                            <option value="U-15" {{ old('kategori_latihan') == 'U-15' ? 'selected' : '' }}>U-15</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-white/80">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full bg-[#0f0304] border border-[#4e1218] p-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-[#d4af37]/20 focus:border-[#d4af37]"
                            placeholder="contoh@email.com"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-white/80">
                            Nomor HP / WhatsApp
                        </label>

                        <input
                            type="text"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            class="w-full bg-[#0f0304] border border-[#4e1218] p-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-[#d4af37]/20 focus:border-[#d4af37]"
                            placeholder="Contoh: 08123456789"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-white/80">
                            Nama Orang Tua / Wali
                        </label>

                        <input
                            type="text"
                            name="nama_orang_tua"
                            value="{{ old('nama_orang_tua') }}"
                            class="w-full bg-[#0f0304] border border-[#4e1218] p-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-[#d4af37]/20 focus:border-[#d4af37]"
                            placeholder="Masukkan nama orang tua/wali"
                        >
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-medium text-white/80">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        rows="4"
                        class="w-full bg-[#0f0304] border border-[#4e1218] p-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-[#d4af37]/20 focus:border-[#d4af37]"
                        placeholder="Masukkan alamat lengkap"
                        required
                    >{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-5">
                    <label class="flex items-start text-white/75 leading-relaxed">
                        <input type="checkbox" required class="mt-1 mr-3">
                        <span>
                            Saya menyatakan data yang diisi benar dan bersedia mengikuti ketentuan pendaftaran SSB HBS.
                        </span>
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full bg-[#d4af37] text-[#120608] py-3 rounded-xl font-bold hover:bg-[#e6c04a] transition"
                >
                    Daftar
                </button>
            </form>

            <p class="text-center mt-6 text-white/60">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#d4af37] font-semibold hover:underline">
                    Login
                </a>
            </p>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-white/40 hover:text-[#d4af37] text-sm">
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

</body>
</html>