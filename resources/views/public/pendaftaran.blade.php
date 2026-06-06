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
            background: linear-gradient(145deg, rgba(80, 15, 28, 0.88), rgba(32, 7, 13, 0.92));
            border: 1px solid rgba(212, 175, 55, 0.35);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(18px);
        }

        .info-card {
            background: rgba(255, 248, 231, 0.92);
            border: 1px solid rgba(212, 175, 55, 0.38);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(16px);
        }

        .form-input {
            width: 100%;
            background: rgba(255, 248, 231, 0.08);
            border: 1px solid rgba(212, 175, 55, 0.32);
            color: #fff8e7;
            padding: 0.75rem;
            border-radius: 0.75rem;
        }

        .form-input::placeholder {
            color: rgba(255, 248, 231, 0.55);
        }

        .form-input:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.18);
        }

        select.form-input option {
            background: #fff8e7;
            color: #1a0b0f;
        }

        select.form-input option:checked {
            background: #d4af37;
            color: #120608;
        }

        input[type="file"].form-input::file-selector-button {
            background: #d4af37;
            color: #120608;
            border: 0;
            padding: 8px 14px;
            border-radius: 10px;
            font-weight: 700;
            margin-right: 12px;
            cursor: pointer;
        }

        .modal-show {
            animation: popupScale 0.35s ease-out;
        }

        @keyframes popupScale {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>

<body class="bg-[#080203] min-h-screen py-10 px-4 overflow-y-auto relative">

    <div class="absolute inset-0 bg-gradient-to-br from-[#080203] via-[#17070b] to-[#2b0b13]"></div>

    <div class="absolute top-16 left-16 w-96 h-96 bg-[#fff4dc]/18 blur-3xl rounded-full"></div>
    <div class="absolute bottom-16 right-16 w-96 h-96 bg-[#d4af37]/18 blur-3xl rounded-full"></div>
    <div class="absolute top-1/2 left-1/2 w-[520px] h-[520px] -translate-x-1/2 -translate-y-1/2 bg-[#7a1025]/25 blur-3xl rounded-full"></div>

    <div class="relative z-10 w-full max-w-5xl mx-auto">

        <div class="text-center mb-8">
            <h1 class="text-5xl font-black text-white">
                SSB <span class="text-[#d4af37]">HBS</span>
            </h1>
            <p class="text-[#fff8e7]/60 mt-2">
                Sistem Informasi Sekolah Sepak Bola
            </p>
        </div>

        <section class="info-card rounded-3xl p-8 mb-8">
            <div class="text-center mb-7">
                <p class="text-[#7a1025] font-bold tracking-widest uppercase mb-2">
                    Informasi Pendaftaran
                </p>
                <h2 class="text-3xl md:text-4xl font-black text-[#1a0b0f]">
                    Pendaftaran Siswa Baru SSB HBS
                </h2>
                <p class="text-[#4b3a36] mt-3">
                    Pastikan orang tua/wali membaca informasi berikut sebelum mengisi formulir pendaftaran.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                <div class="bg-white/75 border border-[#d4af37]/30 rounded-2xl p-5">
                    <h3 class="text-[#7a1025] font-black mb-3">Syarat Pendaftaran</h3>
                    <ul class="space-y-2 text-[#4b3a36] text-sm leading-relaxed">
                        <li>✓ Usia calon siswa 6–18 tahun.</li>
                        <li>✓ Sehat jasmani dan rohani.</li>
                        <li>✓ Mendapat izin dari orang tua/wali.</li>
                        <li>✓ Bersedia mengikuti jadwal latihan sesuai kategori usia.</li>
                        <li>✓ Bersedia mengikuti tata tertib SSB HBS.</li>
                    </ul>
                </div>

                <div class="bg-white/75 border border-[#d4af37]/30 rounded-2xl p-5">
                    <h3 class="text-[#7a1025] font-black mb-3">Kategori Latihan</h3>
                    <ul class="space-y-2 text-[#4b3a36] text-sm leading-relaxed">
                        <li><b>U-10</b> untuk usia sampai 10 tahun.</li>
                        <li><b>U-13</b> untuk usia 11–13 tahun.</li>
                        <li><b>U-15</b> untuk usia 14–15 tahun.</li>
                        <li><b>U-18</b> untuk usia 16–18 tahun.</li>
                    </ul>
                </div>

                <div class="bg-white/75 border border-[#d4af37]/30 rounded-2xl p-5">
                    <h3 class="text-[#7a1025] font-black mb-3">Biaya Pendaftaran</h3>
                    <ul class="space-y-2 text-[#4b3a36] text-sm leading-relaxed">
                        <li><b>Biaya pendaftaran:</b> Rp100.000</li>
                        <li><b>SPP bulanan:</b> Rp150.000</li>
                        <li><b>Jersey:</b> sesuai tipe yang dipilih siswa.</li>
                        <li><b>Turnamen:</b> sesuai kegiatan yang diikuti.</li>
                    </ul>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                <div class="bg-white/75 border border-[#d4af37]/30 rounded-2xl p-5">
                    <h3 class="text-[#7a1025] font-black mb-3">Dokumen yang Perlu Disiapkan</h3>
                    <ul class="space-y-2 text-[#4b3a36] text-sm leading-relaxed">
                        <li>✓ Surat izin orang tua/wali.</li>
                        <li>✓ Pas foto siswa terbaru.</li>
                        <li>✓ Fotokopi/scan ijazah terakhir atau kartu pelajar.</li>
                        <li>✓ Nomor WhatsApp aktif orang tua/wali.</li>
                    </ul>
                </div>

                <div class="bg-white/75 border border-[#d4af37]/30 rounded-2xl p-5">
                    <h3 class="text-[#7a1025] font-black mb-3">Fasilitas Siswa</h3>
                    <ul class="space-y-2 text-[#4b3a36] text-sm leading-relaxed">
                        <li>✓ Program latihan sesuai kategori usia.</li>
                        <li>✓ Pelatih yang mengelola jadwal dan absensi.</li>
                        <li>✓ Riwayat absensi dapat dilihat melalui portal siswa.</li>
                        <li>✓ Informasi SPP, jersey, dan turnamen tersedia dalam sistem.</li>
                    </ul>
                </div>
            </div>

            <div class="bg-[#7a1025] rounded-2xl p-5">
                <h3 class="text-[#d4af37] font-black mb-3">Alur Pendaftaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-3 text-sm">
                    <div class="bg-white/10 border border-white/10 rounded-xl p-4 text-[#fff8e7]">
                        <b>1.</b> Baca informasi dan siapkan dokumen.
                    </div>
                    <div class="bg-white/10 border border-white/10 rounded-xl p-4 text-[#fff8e7]">
                        <b>2.</b> Isi form pendaftaran siswa.
                    </div>
                    <div class="bg-white/10 border border-white/10 rounded-xl p-4 text-[#fff8e7]">
                        <b>3.</b> Upload dokumen pendukung.
                    </div>
                    <div class="bg-white/10 border border-white/10 rounded-xl p-4 text-[#fff8e7]">
                        <b>4.</b> Gabung grup WhatsApp informasi.
                    </div>
                    <div class="bg-white/10 border border-white/10 rounded-xl p-4 text-[#fff8e7]">
                        <b>5.</b> Admin memverifikasi data siswa.
                    </div>
                </div>
            </div>
        </section>

        <div class="glass-card rounded-3xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-black text-[#d4af37]">
                    Form Pendaftaran Siswa
                </h1>
                <p class="text-[#fff8e7]/70 mt-2">
                    Lengkapi data berikut dan upload dokumen pendukung yang diperlukan.
                </p>
            </div>

            @if(session('success'))
                <div class="bg-green-500/20 border border-green-500 text-green-200 p-3 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500 text-red-200 p-3 rounded-xl mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="pendaftaranForm" action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-4">
                    Data Siswa
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="mb-4">
                        <label class="block mb-2 font-semibold text-[#fff8e7]">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" data-label="Nama Lengkap"
                            class="form-input" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold text-[#fff8e7]">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" data-label="Tempat Lahir"
                            class="form-input" placeholder="Contoh: Surabaya" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold text-[#fff8e7]">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" data-label="Tanggal Lahir"
                            class="form-input" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold text-[#fff8e7]">Jenis Kelamin</label>
                        <select name="jenis_kelamin" data-label="Jenis Kelamin" class="form-input" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold text-[#fff8e7]">Kategori Latihan</label>
                        <select name="kategori_latihan" data-label="Kategori Latihan" class="form-input" required>
                            <option value="">Pilih Kategori</option>
                            <option value="U-10" {{ old('kategori_latihan') == 'U-10' ? 'selected' : '' }}>U-10</option>
                            <option value="U-13" {{ old('kategori_latihan') == 'U-13' ? 'selected' : '' }}>U-13</option>
                            <option value="U-15" {{ old('kategori_latihan') == 'U-15' ? 'selected' : '' }}>U-15</option>
                            <option value="U-18" {{ old('kategori_latihan') == 'U-18' ? 'selected' : '' }}>U-18</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold text-[#fff8e7]">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" data-label="Email"
                            class="form-input" placeholder="contoh@email.com" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold text-[#fff8e7]">Nomor HP / WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" data-label="Nomor HP / WhatsApp"
                            class="form-input" placeholder="Contoh: 08123456789" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold text-[#fff8e7]">Nama Orang Tua / Wali</label>
                        <input type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua') }}" data-label="Nama Orang Tua / Wali"
                            class="form-input" placeholder="Masukkan nama orang tua/wali" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 font-semibold text-[#fff8e7]">Alamat</label>
                    <textarea name="alamat" rows="4" data-label="Alamat"
                        class="form-input" placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                </div>

                <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-4">
                    Dokumen Pendukung
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                    <div>
                        <label class="block mb-2 font-semibold text-[#fff8e7]">
                            Surat Izin Orang Tua/Wali
                        </label>
                        <input type="file" name="surat_izin_ortu" data-label="Surat Izin Orang Tua/Wali"
                            class="form-input" accept=".pdf,.jpg,.jpeg,.png" required>
                        <p class="text-[#fff8e7]/50 text-xs mt-2">Format: PDF/JPG/PNG.</p>
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold text-[#fff8e7]">
                            Pas Foto Siswa
                        </label>
                        <input type="file" name="foto_siswa" data-label="Pas Foto Siswa"
                            class="form-input" accept=".jpg,.jpeg,.png" required>
                        <p class="text-[#fff8e7]/50 text-xs mt-2">Format: JPG/PNG.</p>
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold text-[#fff8e7]">
                            Ijazah/Kartu Pelajar
                        </label>
                        <input type="file" name="dokumen_pendukung" data-label="Ijazah atau Kartu Pelajar"
                            class="form-input" accept=".pdf,.jpg,.jpeg,.png" required>
                        <p class="text-[#fff8e7]/50 text-xs mt-2">Format: PDF/JPG/PNG.</p>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="flex items-start text-[#fff8e7]/80 leading-relaxed">
                        <input id="setujuCheckbox" type="checkbox" required class="mt-1 mr-3 accent-[#d4af37]">
                        <span>
                            Saya menyatakan data yang diisi benar, dokumen yang diunggah sesuai, dan bersedia mengikuti ketentuan pendaftaran SSB HBS.
                        </span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-[#d4af37] text-[#120608] py-3 rounded-xl font-bold hover:bg-[#e6c04a] transition shadow-lg shadow-[#d4af37]/20">
                    Daftar
                </button>
            </form>

            <p class="text-center mt-6 text-[#fff8e7]/70">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#d4af37] font-semibold hover:underline">Login</a>
            </p>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-[#fff8e7]/45 hover:text-[#d4af37] text-sm">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <div id="validasiPopup" class="hidden fixed inset-0 bg-black/70 z-50 items-center justify-center px-4">
        <div class="modal-show bg-[#fff8e7] border border-[#d4af37]/40 rounded-3xl p-7 max-w-md w-full shadow-2xl text-center">
            <div class="w-16 h-16 mx-auto rounded-full bg-red-500/15 border border-red-500/30 flex items-center justify-center mb-5">
                <span class="text-red-600 text-3xl font-black">!</span>
            </div>

            <h2 class="text-2xl font-black text-[#7a1025] mb-3">
                Data Belum Lengkap
            </h2>

            <p id="validasiPesan" class="text-[#4b3a36] leading-relaxed mb-6">
                Mohon lengkapi data terlebih dahulu.
            </p>

            <button type="button"
                onclick="tutupValidasiPopup()"
                class="w-full bg-[#7a1025] text-white py-3 rounded-xl font-bold hover:bg-[#600018] transition">
                Oke, Lengkapi
            </button>
        </div>
    </div>

    @if(session('success'))
        <div id="waPopup" class="fixed inset-0 bg-black/70 z-50 flex items-center justify-center px-4">
            <div class="modal-show bg-[#fff8e7] border border-[#d4af37]/40 rounded-3xl p-7 max-w-md w-full shadow-2xl text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-[#d4af37]/20 border border-[#d4af37]/50 flex items-center justify-center mb-5">
                    <span class="text-[#7a1025] text-3xl font-black">✓</span>
                </div>

                <h2 class="text-3xl font-black text-[#7a1025] mb-3">
                    Pendaftaran Berhasil
                </h2>

                <p class="text-[#4b3a36] leading-relaxed mb-6">
                    Data pendaftaran kamu sudah terkirim. Silakan bergabung ke grup WhatsApp untuk mendapatkan informasi selanjutnya dari SSB HBS.
                </p>

                <a href="https://chat.whatsapp.com/FVuiAbazutLLWdKIkEbe4X"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="block w-full bg-[#d4af37] text-[#120608] py-3 rounded-xl font-bold hover:bg-[#e6c04a] transition mb-3">
                    Gabung Grup WhatsApp
                </a>

                <button type="button"
                    onclick="document.getElementById('waPopup').classList.add('hidden')"
                    class="w-full border border-[#7a1025]/30 text-[#7a1025] py-3 rounded-xl font-bold hover:bg-[#7a1025] hover:text-white transition">
                    Tutup
                </button>
            </div>
        </div>
    @endif

    <script>
        const form = document.getElementById('pendaftaranForm');
        const popup = document.getElementById('validasiPopup');
        const pesan = document.getElementById('validasiPesan');

        form.addEventListener('submit', function(e) {
            const wajibDiisi = form.querySelectorAll('[required]');

            for (const field of wajibDiisi) {
                if (field.type === 'checkbox' && !field.checked) {
                    e.preventDefault();
                    pesan.innerText = 'Mohon centang pernyataan persetujuan terlebih dahulu.';
                    popup.classList.remove('hidden');
                    popup.classList.add('flex');
                    field.focus();
                    return;
                }

                if (field.type !== 'checkbox' && !field.value.trim()) {
                    e.preventDefault();

                    const label = field.getAttribute('data-label') || 'Data';
                    pesan.innerText = label + ' wajib diisi. Mohon lengkapi terlebih dahulu.';

                    popup.classList.remove('hidden');
                    popup.classList.add('flex');
                    field.focus();
                    return;
                }

                if (field.name === 'email' && field.value.trim() !== '') {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (!emailPattern.test(field.value.trim())) {
                        e.preventDefault();
                        pesan.innerText = 'Format email tidak valid. Mohon masukkan email yang benar.';
                        popup.classList.remove('hidden');
                        popup.classList.add('flex');
                        field.focus();
                        return;
                    }
                }
            }
        });

        function tutupValidasiPopup() {
            popup.classList.add('hidden');
            popup.classList.remove('flex');
        }
    </script>

</body>
</html>