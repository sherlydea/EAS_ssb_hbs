<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSB HBS - Sekolah Sepak Bola</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-display {
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            letter-spacing: 1px;
        }

        .hero-bg {
            background-image:
                linear-gradient(to right, rgba(10,0,3,0.95), rgba(20,0,5,0.78), rgba(20,0,5,0.35)),
                url("{{ asset('images/beranda.jpg') }}");
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-[#080203] text-white overflow-x-hidden">

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 w-full z-50 bg-[#080203]/85 backdrop-blur-xl border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
    <a href="#beranda" class="flex items-center gap-3">

    <!-- LOGO -->
    <div class="w-14 h-14 flex items-center justify-center">
        <img
            src="{{ asset('images/logo.png') }}"
            alt="Logo SSB HBS"
            class="w-full h-full object-contain"
        >
    </div>

    <!-- TEXT -->
    <div>
        <h1 class="text-2xl font-extrabold">
            SSB <span class="text-[#d4af37]">HBS</span>
        </h1>

        <p class="text-xs text-white/50">
            Membentuk Potensi, Meraih Prestasi
        </p>
    </div>

</a>

        <div class="hidden md:flex items-center gap-7 text-sm font-semibold text-white/75">
            <a href="#beranda" class="hover:text-[#d4af37]">Beranda</a>
            <a href="#tentang" class="hover:text-[#d4af37]">Tentang</a>
            <a href="#program" class="hover:text-[#d4af37]">Program</a>
            <a href="#keunggulan" class="hover:text-[#d4af37]">Keunggulan</a>
            <a href="#galeri" class="hover:text-[#d4af37]">Galeri</a>
            <a href="#prestasi" class="hover:text-[#d4af37]">Prestasi</a>
            <a href="#kontak" class="hover:text-[#d4af37]">Kontak</a>
            <a href="{{ route('login') }}" class="border border-[#d4af37] text-[#d4af37] px-6 py-2.5 rounded-full hover:bg-[#d4af37] hover:text-[#120608] transition">
                Login
            </a>
        </div>

        <button id="menuBtn" class="md:hidden text-[#d4af37] text-3xl">☰</button>
    </div>
</nav>

<!-- MOBILE MENU -->
<div id="mobileMenu" class="fixed top-0 right-0 w-72 h-full bg-[#140508] z-50 translate-x-full transition duration-300 border-l border-white/10 p-6">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-xl font-bold text-[#d4af37]">Menu</h2>
        <button id="closeMenu" class="text-3xl text-[#d4af37]">&times;</button>
    </div>

    <div class="flex flex-col gap-5 text-white/75 font-semibold">
        <a href="#beranda">Beranda</a>
        <a href="#tentang">Tentang</a>
        <a href="#program">Program</a>
        <a href="#keunggulan">Keunggulan</a>
        <a href="#galeri">Galeri</a>
        <a href="#prestasi">Prestasi</a>
        <a href="#kontak">Kontak</a>
        <a href="{{ route('login') }}" class="border border-[#d4af37] text-[#d4af37] text-center py-3 rounded-full">Login</a>
    </div>
</div>

<!-- BERANDA -->
<section id="beranda" class="hero-bg min-h-screen flex items-center relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_50%,rgba(139,0,20,0.35),transparent_45%)]"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 pt-24 w-full">
        <div class="max-w-3xl">
            <p class="text-[#d4af37] font-bold mb-5 tracking-widest uppercase">
                Sekolah Sepak Bola HBS
            </p>

            <h1 class="font-display text-5xl md:text-7xl leading-tight mb-6">
                Membentuk Karakter,<br>
                Mengasah Talenta,<br>
                <span class="text-[#d4af37]">Meraih Prestasi.</span>
            </h1>

            <p class="text-white/75 text-lg leading-relaxed mb-10 max-w-2xl">
                SSB HBS hadir untuk membina generasi muda yang disiplin, sportif,
                dan berprestasi melalui latihan terstruktur serta sistem informasi yang terintegrasi.
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="{{ route('pendaftaran.create') }}" class="bg-[#8d001f] px-8 py-4 rounded-xl font-bold hover:bg-[#a50028] transition">
                    Daftar Sekarang
                </a>

                <a href="#tentang" class="border border-[#d4af37] px-8 py-4 rounded-xl font-bold hover:bg-[#d4af37] hover:text-[#120608] transition">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>
</section>

<!-- TENTANG SSB HBS -->
<section id="tentang" class="min-h-screen flex items-center bg-gradient-to-b from-[#0a0204] to-[#1c0508] py-24 relative overflow-hidden">
    <!-- Background blur shapes -->
    <div class="absolute top-16 right-0 w-96 h-96 bg-[#8d001f]/20 blur-3xl rounded-full"></div>
    <div class="absolute bottom-12 left-0 w-80 h-80 bg-[#d4af37]/10 blur-3xl rounded-full"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <!-- Text Section -->
            <div class="lg:col-span-5">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-4">
                    Tentang SSB HBS
                </p>

                <h2 class="font-display text-4xl md:text-6xl leading-tight mb-6 text-white">
                    Dari Akar Rumput<br>
                    Menuju Prestasi
                </h2>

                <p class="text-white/70 text-lg leading-relaxed mb-6 text-justify">
                    Selamat datang di platform resmi <span class="text-white font-semibold">SSB HBS Surabaya</span>,
                    pusat pembinaan sepak bola usia dini terpercaya di Jawa Timur.
                </p>

                <p class="text-white/70 text-lg leading-relaxed mb-6 text-justify">
                    Terinspirasi dari semangat klub legendaris
                    <span class="text-[#d4af37] font-semibold">Houdt Braef Stant (HBS Surabaya)</span>
                    yang berdiri sejak 19 Januari 1913, kami berkomitmen mengorbitkan bakat muda dari akar rumput menuju panggung tertinggi.
                    Saat ini, SSB HBS aktif membina kelompok umur U-10 hingga U-18 melalui manajemen profesional untuk melahirkan generasi pesepak bola
                    yang berkarakter unggul, bermental juara, religius, dan mampu berkontribusi nyata bagi sepak bola Indonesia.
                </p>
            </div>

            <!-- Image Section -->
            <div class="lg:col-span-7 flex justify-center items-center">
                <div class="relative w-full max-w-3xl rounded-3xl overflow-hidden shadow-2xl">
                    <img
                        src="{{ asset('images/tentang.jpg') }}"
                        alt="Tentang SSB HBS"
                        class="w-full h-[450px] object-cover transition-transform duration-500 hover:scale-105"
                    >
                    <!-- Optional overlay text if needed -->
                    <!-- <div class="absolute bottom-4 left-4 bg-black/50 text-white p-3 rounded">SSB HBS Training</div> -->
                </div>
            </div>

        </div>
    </div>
</section>

<!-- PROGRAM -->
<section id="program" class="min-h-screen flex items-center bg-[#120305] py-24">
    <div class="max-w-7xl mx-auto px-6 w-full">
        <div class="text-center mb-14">
            <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-4">Program Latihan</p>
            <h2 class="font-display text-4xl md:text-6xl">Kategori Pembinaan</h2>
            <p class="text-white/60 mt-4 max-w-2xl mx-auto">
                Program latihan disesuaikan berdasarkan usia, kemampuan, dan tahapan perkembangan siswa.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-[#1a0608] border border-[#4e1218] rounded-3xl p-7 min-h-[250px] hover:-translate-y-2 transition">
                <h3 class="text-5xl font-black text-[#d4af37] mb-5">U-10</h3>
                <p class="text-white/70 text-sm leading-relaxed mb-5">
                    Fokus: Pengenalan sepak bola yang menyenangkan.<br>
                    Materi: Kemampuan motorik, kelincahan, dan teknik dasar mengontrol bola.
                </p>
            </div>

            <div class="bg-[#1a0608] border border-[#4e1218] rounded-3xl p-7 min-h-[250px] hover:-translate-y-2 transition">
                <h3 class="text-5xl font-black text-[#d4af37] mb-5">U-13</h3>
                <p class="text-white/70 text-sm leading-relaxed mb-5">
                    Fokus: Transisi ke pemahaman taktik dasar.<br>
                    Materi: Pemantapan teknik individu, pengenalan posisi, dan kerja sama tim.
                </p>
            </div>

            <div class="bg-[#1a0608] border border-[#4e1218] rounded-3xl p-7 min-h-[250px] hover:-translate-y-2 transition">
                <h3 class="text-5xl font-black text-[#d4af37] mb-5">U-15</h3>
                <p class="text-white/70 text-sm leading-relaxed mb-5">
                    Fokus: Pengembangan strategi permainan dan fisik.<br>
                    Materi: Taktik menyerang-bertahan, organisasi tim, dan penguatan fisik.
                </p>
            </div>

            <div class="bg-[#1a0608] border border-[#4e1218] rounded-3xl p-7 min-h-[250px] hover:-translate-y-2 transition">
                <h3 class="text-5xl font-black text-[#d4af37] mb-5">U-18</h3>
                <p class="text-white/70 text-sm leading-relaxed mb-5">
                    Fokus: Kesiapan menuju sepak bola prestasi/profesional.<br>
                    Materi: Taktik tingkat lanjut, simulasi kompetisi, dan mental bertanding.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- KEUNGGULAN -->
<section id="keunggulan" class="min-h-screen flex items-center bg-[#080203] py-24 relative overflow-hidden">
    <div class="absolute top-20 left-0 w-[420px] h-[420px] bg-[#8d001f]/20 blur-3xl rounded-full"></div>
    <div class="absolute bottom-0 right-0 w-[420px] h-[420px] bg-[#d4af37]/10 blur-3xl rounded-full"></div>

    <div class="max-w-7xl mx-auto px-6 w-full relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-14 items-center">

            <!-- Text Column -->
            <div class="lg:col-span-5">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-4">
                    Keunggulan
                </p>

                <h2 class="font-display text-4xl md:text-6xl leading-tight mb-6">
                    Mengapa Memilih<br>
                    <span class="text-[#d4af37]">SSB HBS?</span>
                </h2>

                <p class="text-white/65 text-lg leading-relaxed mb-8 text-justify">
                    SSB HBS menghadirkan sistem pembinaan sepak bola yang terarah, modern, dan mudah diakses. 
                    Setiap proses latihan, administrasi, absensi, hingga informasi kegiatan siswa dikelola secara lebih tertata.
                </p>

                <a href="{{ route('pendaftaran.create') }}"
                   class="inline-block bg-[#d4af37] text-[#120608] px-8 py-4 rounded-xl font-bold hover:bg-[#e8c253] transition">
                    Daftar Sekarang
                </a>
            </div>

            <!-- Feature Cards Column -->
            <div class="lg:col-span-7">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <div class="group bg-[#140506]/90 border border-[#4e1218] rounded-3xl p-7 hover:-translate-y-2 hover:border-[#d4af37]/60 transition duration-300 shadow-xl">
                        <h3 class="text-[#d4af37] text-xl font-bold mb-3">
                            Pelatih Berpengalaman
                        </h3>

                        <p class="text-white/60 text-sm leading-relaxed">
                            Latihan didampingi pelatih yang memahami pembinaan usia muda
                            dan mampu mengarahkan siswa sesuai potensi masing-masing.
                        </p>
                    </div>

                    <div class="group bg-[#140506]/90 border border-[#4e1218] rounded-3xl p-7 hover:-translate-y-2 hover:border-[#d4af37]/60 transition duration-300 shadow-xl">
                        <h3 class="text-[#d4af37] text-xl font-bold mb-3">
                            Jadwal Terstruktur
                        </h3>

                        <p class="text-white/60 text-sm leading-relaxed">
                            Jadwal latihan dan turnamen tersusun rapi sehingga siswa
                            dapat mengetahui informasi kegiatan secara lebih jelas.
                        </p>
                    </div>

                    <div class="group bg-[#140506]/90 border border-[#4e1218] rounded-3xl p-7 hover:-translate-y-2 hover:border-[#d4af37]/60 transition duration-300 shadow-xl">
                        <h3 class="text-[#d4af37] text-xl font-bold mb-3">
                            Absensi Digital
                        </h3>

                        <p class="text-white/60 text-sm leading-relaxed">
                            Riwayat kehadiran siswa tercatat secara digital sehingga
                            memudahkan pemantauan kedisiplinan latihan.
                        </p>
                    </div>

                    <div class="group bg-[#140506]/90 border border-[#4e1218] rounded-3xl p-7 hover:-translate-y-2 hover:border-[#d4af37]/60 transition duration-300 shadow-xl">
                        <h3 class="text-[#d4af37] text-xl font-bold mb-3">
                            Administrasi Mudah
                        </h3>

                        <p class="text-white/60 text-sm leading-relaxed">
                            Pendaftaran, tagihan SPP, turnamen, dan pemesanan jersey
                            dapat dipantau lebih mudah melalui sistem.
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- GALERI -->
<section id="galeri" class="min-h-screen bg-[#120305] py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-4">Galeri</p>
            <h2 class="font-display text-4xl md:text-6xl">Dokumentasi Kegiatan</h2>
            <p class="text-white/60 mt-4 max-w-2xl mx-auto">
                Dokumentasi latihan, pertandingan, turnamen, dan kegiatan siswa SSB HBS.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @for($i = 1; $i <= 12; $i++)
                <button type="button"
                        onclick="openLightbox('{{ asset('images/galeri/'.$i.'.jpg') }}')"
                        class="group overflow-hidden rounded-3xl bg-[#1a0608]">
                    <img src="{{ asset('images/galeri/'.$i.'.jpg') }}"
                         alt="Galeri {{ $i }}"
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                </button>
            @endfor
        </div>
    </div>
</section>

<!-- PRESTASI -->
<section id="prestasi" class="min-h-screen bg-[#080203] py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-4">
                Prestasi
            </p>

            <h2 class="font-display text-4xl md:text-6xl">
                Jejak Prestasi
            </h2>

            <p class="text-white/60 mt-4 max-w-2xl mx-auto">
                Beberapa pencapaian siswa SSB HBS dalam kegiatan dan turnamen sepak bola.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $prestasi = [
                    ['nama' => 'Raka Pratama', 'juara' => 'Juara 1 Turnamen U-13 Surabaya Cup'],
                    ['nama' => 'Dimas Aditama', 'juara' => 'Top Scorer Liga Pelajar U-15'],
                    ['nama' => 'Farel Nugraha', 'juara' => 'Best Player HBS Internal League'],
                    ['nama' => 'Arkan Maulana', 'juara' => 'Juara 2 Festival Sepak Bola U-10'],
                    ['nama' => 'Bima Saputra', 'juara' => 'Kiper Terbaik Turnamen Junior'],
                    ['nama' => 'Tim SSB HBS', 'juara' => 'Juara 3 Kompetisi Antar SSB'],
                ];
            @endphp

            @foreach($prestasi as $index => $item)
                <div class="bg-[#1a0608] border border-[#4e1218] rounded-3xl overflow-hidden hover:-translate-y-2 hover:border-[#d4af37]/60 transition duration-300 shadow-xl">
                    <img
                        src="{{ asset('images/prestasi/prestasi'.($index + 1).'.jpg') }}"
                        alt="Prestasi {{ $index + 1 }}"
                        class="w-full h-56 object-cover"
                    >

                    <div class="p-6">
                        <p class="text-[#d4af37] text-sm font-bold tracking-widest uppercase mb-3">
                            {{ $item['nama'] }}
                        </p>

                        <h3 class="text-xl font-bold leading-snug">
                            {{ $item['juara'] }}
                        </h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- KONTAK -->
<section id="kontak" class="min-h-screen bg-[#120305] py-24 flex items-center">
    <div class="max-w-7xl mx-auto px-6 w-full">
        <div class="text-center mb-14">
            <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-4">Kontak</p>
            <h2 class="font-display text-4xl md:text-6xl">Hubungi Kami</h2>
            <p class="text-white/60 mt-4 max-w-2xl mx-auto">
                Silakan hubungi SSB HBS untuk informasi pendaftaran, jadwal latihan, dan kegiatan turnamen.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-[#1a0608] border border-[#4e1218] rounded-3xl p-8 text-center">
                <div class="text-4xl mb-4"></div>
                <h3 class="text-[#d4af37] font-bold mb-3">Alamat</h3>
                <p class="text-white/60 text-sm leading-relaxed">
                    Lapangan SSB HBS, Surabaya, Jawa Timur
                </p>
            </div>

            <div class="bg-[#1a0608] border border-[#4e1218] rounded-3xl p-8 text-center">
                <div class="text-4xl mb-4"></div>
                <h3 class="text-[#d4af37] font-bold mb-3">Telepon</h3>
                <p class="text-white/60 text-sm leading-relaxed">
                    0872-9903-1234
                </p>
            </div>

            <div class="bg-[#1a0608] border border-[#4e1218] rounded-3xl p-8 text-center">
                <div class="text-4xl mb-4"></div>
                <h3 class="text-[#d4af37] font-bold mb-3">Email</h3>
                <p class="text-white/60 text-sm leading-relaxed">
                    ssbhbsofficial@gmail.com
                </p>
            </div>
        </div>
    </div>
</section>

<!-- LIGHTBOX GALERI -->
<div id="lightbox" class="hidden fixed inset-0 bg-black/90 z-[999] items-center justify-center p-6">
    <button onclick="closeLightbox()" class="absolute top-6 right-8 text-white text-4xl">&times;</button>
    <img id="lightboxImage" src="" class="max-w-full max-h-[85vh] rounded-2xl">
</div>

<!-- FOOTER -->
<footer class="bg-black py-8 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="font-bold text-white/60">SSB <span class="text-[#d4af37]">HBS</span></p>
        <p class="text-white/40 text-sm">&copy; 2026 SSB HBS. Seluruh Hak Cipta Dilindungi.</p>
    </div>
</footer>

<script>
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const closeMenu = document.getElementById('closeMenu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.remove('translate-x-full');
    });

    closeMenu.addEventListener('click', () => {
        mobileMenu.classList.add('translate-x-full');
    });

    document.querySelectorAll('#mobileMenu a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('translate-x-full');
        });
    });

    function openLightbox(src) {
        document.getElementById('lightboxImage').src = src;
        document.getElementById('lightbox').classList.remove('hidden');
        document.getElementById('lightbox').classList.add('flex');
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.add('hidden');
        document.getElementById('lightbox').classList.remove('flex');
        document.getElementById('lightboxImage').src = '';
    }
</script>

</body>
</html>