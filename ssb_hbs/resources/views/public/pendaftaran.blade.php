<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl mx-auto">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-red-700">Form Pendaftaran Siswa</h1>
            <p class="text-gray-600 mt-2">
                Silakan isi data berikut untuk mendaftar sebagai siswa SSB HBS.
            </p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
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
                    <label class="block mb-1 font-semibold text-gray-700">Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama') }}"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Masukkan nama lengkap"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">Tempat Lahir</label>
                    <input
                        type="text"
                        name="tempat_lahir"
                        value="{{ old('tempat_lahir') }}"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Contoh: Surabaya"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">Tanggal Lahir</label>
                    <input
                        type="date"
                        name="tanggal_lahir"
                        value="{{ old('tanggal_lahir') }}"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">Jenis Kelamin</label>
                    <select
                        name="jenis_kelamin"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                        required
                    >
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">Kategori Latihan</label>
                    <select
                        name="kategori_latihan"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                        required
                    >
                        <option value="">Pilih Kategori</option>
                        <option value="U-10" {{ old('kategori_latihan') == 'U-10' ? 'selected' : '' }}>U-10</option>
                        <option value="U-12" {{ old('kategori_latihan') == 'U-12' ? 'selected' : '' }}>U-12</option>
                        <option value="U-15" {{ old('kategori_latihan') == 'U-15' ? 'selected' : '' }}>U-15</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="contoh@email.com"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">Nomor HP / WhatsApp</label>
                    <input
                        type="text"
                        name="no_hp"
                        value="{{ old('no_hp') }}"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Contoh: 08123456789"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">Nama Orang Tua / Wali</label>
                    <input
                        type="text"
                        name="nama_orang_tua"
                        value="{{ old('nama_orang_tua') }}"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Masukkan nama orang tua/wali"
                    >
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Alamat</label>
                <textarea
                    name="alamat"
                    rows="4"
                    class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                    placeholder="Masukkan alamat lengkap"
                    required
                >{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-5">
                <label class="flex items-start text-gray-700">
                    <input type="checkbox" required class="mt-1 mr-2">
                    <span>
                        Saya menyatakan data yang diisi benar dan bersedia mengikuti ketentuan pendaftaran SSB HBS.
                    </span>
                </label>
            </div>

            <button
                type="submit"
                class="w-full bg-red-600 text-white py-3 rounded hover:bg-red-700 font-semibold transition"
            >
                Daftar
            </button>
        </form>

        <p class="text-center mt-5 text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-red-600 font-semibold hover:underline">
                Login
            </a>
        </p>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-red-600 text-sm">
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>