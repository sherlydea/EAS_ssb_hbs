<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <nav class="bg-red-700 text-white px-6 py-4 flex justify-between items-center shadow-md">
        <div class="text-2xl font-bold">SSB HBS</div>

        <div class="space-x-4">
            <a href="{{ route('home') }}" class="hover:text-gray-200">Home</a>
            <a href="#about" class="hover:text-gray-200">About</a>
            <a href="#program" class="hover:text-gray-200">Program</a>
            <a href="{{ route('login') }}" class="hover:text-gray-200">Login</a>
            <a href="{{ route('pendaftaran.create') }}" class="bg-white text-red-700 px-4 py-2 rounded font-semibold hover:bg-gray-100">
                Daftar
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-red-600 text-white py-32 text-center px-6">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            Selamat Datang di SSB HBS
        </h1>

        <p class="text-lg md:text-xl mb-8">
            Sekolah Sepak Bola untuk Generasi Muda Berprestasi
        </p>

        <div class="flex justify-center gap-4">
            <a href="{{ route('pendaftaran.create') }}" class="bg-white text-red-600 px-6 py-3 font-semibold rounded hover:bg-gray-100">
                Daftar Sekarang
            </a>

            <a href="{{ route('login') }}" class="bg-gray-200 text-red-600 px-6 py-3 font-semibold rounded hover:bg-white">
                Login
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 px-6 bg-white">
        <h2 class="text-3xl font-bold text-center mb-6">
            Tentang SSB HBS
        </h2>

        <p class="max-w-3xl mx-auto text-center text-gray-700 leading-relaxed">
            SSB HBS adalah sekolah sepak bola yang fokus melatih skill, kedisiplinan,
            dan kerja sama tim bagi anak-anak dan remaja. Kami memiliki pelatih
            berpengalaman dan jadwal latihan terstruktur untuk mendukung perkembangan
            siswa.
        </p>
    </section>

    <!-- Program Section -->
    <section id="program" class="py-20 px-6 bg-gray-100">
        <h2 class="text-3xl font-bold text-center mb-10">
            Program Latihan
        </h2>

        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="font-bold text-xl mb-2 text-red-700">U-10</h3>
                <p class="text-gray-700">
                    Program latihan untuk usia 8-10 tahun, fokus pada skill dasar,
                    koordinasi tubuh, dan fun games.
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="font-bold text-xl mb-2 text-red-700">U-12</h3>
                <p class="text-gray-700">
                    Program latihan untuk usia 11-12 tahun, fokus pada teknik,
                    strategi dasar, dan kerja sama tim.
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="font-bold text-xl mb-2 text-red-700">U-15</h3>
                <p class="text-gray-700">
                    Program latihan untuk usia 13-15 tahun, fokus pada teknik
                    lanjutan, fisik, dan taktik pertandingan.
                </p>
            </div>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section class="py-20 px-6 bg-white">
        <h2 class="text-3xl font-bold text-center mb-10">
            Keunggulan SSB HBS
        </h2>

        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="p-6 rounded-lg bg-gray-100 text-center">
                <h3 class="font-bold text-red-700 mb-2">Pelatih Berpengalaman</h3>
                <p class="text-sm text-gray-700">Latihan dibimbing oleh pelatih yang memahami pembinaan usia muda.</p>
            </div>

            <div class="p-6 rounded-lg bg-gray-100 text-center">
                <h3 class="font-bold text-red-700 mb-2">Jadwal Terstruktur</h3>
                <p class="text-sm text-gray-700">Siswa dapat melihat jadwal latihan secara online.</p>
            </div>

            <div class="p-6 rounded-lg bg-gray-100 text-center">
                <h3 class="font-bold text-red-700 mb-2">Absensi Online</h3>
                <p class="text-sm text-gray-700">Riwayat kehadiran siswa dapat dipantau melalui sistem.</p>
            </div>

            <div class="p-6 rounded-lg bg-gray-100 text-center">
                <h3 class="font-bold text-red-700 mb-2">Pembayaran Online</h3>
                <p class="text-sm text-gray-700">Siswa dapat melihat status dan riwayat pembayaran.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-red-700 text-white py-16 text-center px-6">
        <h2 class="text-3xl font-bold mb-4">
            Ingin Bergabung dengan SSB HBS?
        </h2>

        <p class="mb-6">
            Daftarkan diri sekarang dan mulai perjalanan sepak bola bersama kami.
        </p>

        <a href="{{ route('pendaftaran.create') }}" class="bg-white text-red-700 px-6 py-3 rounded font-semibold hover:bg-gray-100">
            Daftar Sekarang
        </a>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 text-center">
        <p>&copy; 2026 SSB HBS. All Rights Reserved.</p>
    </footer>

</body>
</html>