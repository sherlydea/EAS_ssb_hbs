<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Turnamen Saya - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f5f0e6] text-[#1a0b0f] min-h-screen overflow-x-hidden">

    @include('siswa.partials.sidebar')

    <main class="pt-28 px-6 py-10 min-h-screen">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#8d001f] font-bold tracking-widest uppercase mb-3">
                    Turnamen Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight text-[#1a0b0f]">
                    Informasi Turnamen Aktif
                </h1>

                <p class="text-[#4b3a36] mt-3 max-w-2xl">
                    Lihat turnamen yang kamu ikuti, status pembayaran, dan upload bukti pembayaran.
                </p>
            </section>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 font-semibold shadow">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 font-semibold shadow">
                    {{ session('error') }}
                </div>
            @endif

            <section class="grid grid-cols-1 gap-6 mb-6">
                @forelse($turnamens as $turnamen)
                    <div class="bg-[#fff8f0] border border-[#8d001f]/30 rounded-3xl p-7 shadow-lg">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                            <div>
                                <p class="text-[#d4af37] text-sm font-bold tracking-widest uppercase mb-2">
                                    {{ $turnamen->nama_turnamen }}
                                </p>
                                <h3 class="font-bold text-xl text-[#1a0b0f]">{{ $turnamen->nama_turnamen }}</h3>
                                <p class="text-[#1a0b0f]/80 text-sm mt-1">
                                    Lokasi: {{ $turnamen->lokasi }}
                                </p>
                                <p class="text-[#1a0b0f]/80 text-sm mt-1">
                                    Tanggal: {{ \Carbon\Carbon::parse($turnamen->tanggal)->format('d F Y') }}
                                </p>
                                <p class="text-[#1a0b0f]/80 text-sm mt-1">
                                    Biaya: Rp{{ number_format($turnamen->biaya, 0, ',', '.') }}
                                </p>
                                <p class="text-[#1a0b0f]/80 text-sm mt-2">
                                    Status Verifikasi: 
                                    @if($turnamen->status_pembayaran == 'Belum Bayar')
                                        <span class="bg-red-500/20 text-red-700 px-3 py-1 rounded-full font-bold text-xs">Belum Bayar</span>
                                    @elseif($turnamen->status_pembayaran == 'Menunggu Konfirmasi')
                                        <span class="bg-yellow-500/20 text-yellow-700 px-3 py-1 rounded-full font-bold text-xs">Menunggu Konfirmasi</span>
                                    @elseif($turnamen->status_pembayaran == 'Lunas')
                                        <span class="bg-green-500/20 text-green-700 px-3 py-1 rounded-full font-bold text-xs">Terdaftar / Lunas</span>
                                    @endif
                                </p>
                            </div>

                            <div class="flex flex-col gap-2 mt-4 md:mt-0">
                                @if($turnamen->status_pembayaran != 'Lunas')
                                    <form action="{{ route('siswa.turnamen.upload', $turnamen->turnamen_siswa_id) }}" method="POST" enctype="multipart/form-data" class="upload-bukti-form">
                                        @csrf
                                        <label class="block text-xs font-bold text-[#4b3a36] uppercase mb-1">Pilih File Bukti Pembayaran:</label>
                                        <input type="file" name="bukti_pembayaran" class="text-sm mb-2 text-black block w-full file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#8d001f]/10 file:text-[#8d001f] hover:file:bg-[#8d001f]/20" required>
                                        <button type="submit" class="bg-[#8d001f] text-[#fff8e7] px-5 py-2.5 rounded-xl font-bold hover:bg-[#d4af37] hover:text-[#1a0b0f] transition shadow w-full md:w-auto">
                                            Upload Bukti
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ asset('uploads/bukti_turnamen/'.$turnamen->bukti_pembayaran) }}" target="_blank"
                                       class="bg-[#fff8f0] border border-[#d4af37] px-5 py-2.5 rounded-xl font-bold hover:bg-[#d4af37] hover:text-[#fff8e7] transition text-center block shadow">
                                        Lihat Bukti Transfer
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-[#fff8f0] border border-[#8d001f]/30 rounded-3xl p-7 shadow-lg text-center">
                        <p class="text-[#1a0b0f]/60">
                            Belum ada jadwal turnamen aktif yang didaftarkan untuk Anda saat ini.
                        </p>
                    </div>
                @endforelse
            </section>

            <section class="mt-12">
                <h2 class="text-[#8d001f] text-2xl font-bold mb-4">Riwayat Turnamen</h2>
                <div class="bg-[#fff8f0] border border-[#8d001f]/30 rounded-3xl p-7 shadow-lg overflow-x-auto">
                    <table class="w-full border border-[#8d001f]/20">
                        <thead class="bg-[#fff3e8]">
                            <tr>
                                <th class="border p-3 text-left text-[#1a0b0f]/75">Turnamen</th>
                                <th class="border p-3 text-left text-[#1a0b0f]/75">Tanggal Pelaksanaan</th>
                                <th class="border p-3 text-left text-[#1a0b0f]/75">Biaya</th>
                                <th class="border p-3 text-left text-[#1a0b0f]/75">Status Verifikasi</th>
                                <th class="border p-3 text-left text-[#1a0b0f]/75">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $item)
                                <tr class="hover:bg-[#fff3e8]/10 transition">
                                    <td class="border p-3 text-[#1a0b0f] font-semibold">{{ $item->nama_turnamen }}</td>
                                    <td class="border p-3 text-[#1a0b0f]">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}
                                    </td>
                                    <td class="border p-3 text-[#1a0b0f] font-medium">Rp{{ number_format($item->biaya, 0, ',', '.') }}</td>
                                    <td class="border p-3 text-[#1a0b0f]">
                                        @if($item->status_pembayaran == 'Belum Bayar')
                                            <span class="bg-red-500/20 text-red-700 px-3 py-1 rounded-full font-bold text-xs">Belum Bayar</span>
                                        @elseif($item->status_pembayaran == 'Menunggu Konfirmasi')
                                            <span class="bg-yellow-500/20 text-yellow-700 px-3 py-1 rounded-full font-bold text-xs">Menunggu Konfirmasi</span>
                                        @elseif($item->status_pembayaran == 'Lunas')
                                            <span class="bg-green-500/20 text-green-700 px-3 py-1 rounded-full font-bold text-xs">Terdaftar / Lunas</span>
                                        @endif
                                    </td>
                                    <td class="border p-3">
                                        @if($item->bukti_pembayaran)
                                            <a href="{{ asset('uploads/bukti_turnamen/'.$item->bukti_pembayaran) }}" target="_blank" class="text-[#d4af37] font-bold hover:underline">
                                                Lihat Berkas
                                            </a>
                                        @else
                                            <span style="color: #aaa;">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border p-4 text-center text-[#1a0b0f]/60">
                                        Belum ada rekaman data riwayat keikutsertaan turnamen.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.upload-bukti-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                const input = form.querySelector('input[type="file"]');
                if (input.files.length > 0) {
                    const file = input.files[0];
                    const extension = file.name.split('.').pop().toLowerCase();
                    const validExtensions = ['jpg', 'jpeg', 'png'];
                    
                    if (!validExtensions.includes(extension)) {
                        alert('Format berkas tidak valid! Harap upload file gambar dengan ekstensi JPG, JPEG, atau PNG.');
                        e.preventDefault();
                        return;
                    }

                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran berkas terlalu besar! Maksimal ukuran file bukti pembayaran adalah 2MB.');
                        e.preventDefault();
                    }
                }
            });
        });
    });
    </script>
</body>
</html>