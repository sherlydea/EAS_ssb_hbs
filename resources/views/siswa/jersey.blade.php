<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jersey Saya - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f5f0e6] text-black min-h-screen overflow-x-hidden px-6 py-10">

@include('siswa.partials.sidebar')

<main class="pt-28 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <section class="mb-10">
            <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                Jersey Saya
            </p>
            <h1 class="text-4xl md:text-5xl font-black leading-tight">
                Pemesanan Jersey
            </h1>
            <p class="text-black/60 mt-3 max-w-2xl">
                Pilih tipe jersey, ukuran, nama punggung, dan nomor punggung sesuai kebutuhan siswa.
            </p>
            @if(session('error'))
                <div class="bg-red-500/15 text-red-600 border border-red-500/30 p-4 rounded-2xl mt-3">
                    {{ session('error') }}
                </div>
            @endif
        </section>

        <!-- Daftar Jersey & Info Transfer -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Daftar Jersey -->
            <div class="lg:col-span-2 bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                    Pilihan Jersey SSB HBS
                </p>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[500px] text-left">
                        <thead>
                            <tr class="border-b border-[#4e1218]/25 text-black/60">
                                <th class="py-3 px-4">Tipe Jersey</th>
                                <th class="py-3 px-4">Harga</th>
                                <th class="py-3 px-4">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#4e1218]/25">
                            @foreach($jerseys as $jersey)
                            <tr class="hover:bg-[#fff3e8]/20 transition">
                                <td class="py-3 px-4 font-bold text-[#d4af37]">{{ $jersey->tipe_jersey }}</td>
                                <td class="py-3 px-4 text-black/70">Rp{{ number_format($jersey->harga,0,',','.') }}</td>
                                <td class="py-3 px-4 text-black/70">{{ $jersey->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info Transfer -->
            <div class="bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                    Informasi Transfer
                </p>
                <div class="space-y-4">
                    <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                        <p class="font-bold mb-1">Bank</p>
                        <p class="text-black/60">BCA</p>
                    </div>
                    <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                        <p class="font-bold mb-1">Nomor Rekening</p>
                        <p class="text-black/60">1234567890</p>
                    </div>
                    <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                        <p class="font-bold mb-1">Atas Nama</p>
                        <p class="text-black/60">SSB HBS</p>
                    </div>
                    <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                        <p class="font-bold mb-1">Keterangan Transfer</p>
                        <p class="text-black/60">Tulis keterangan: Jersey - Nama Siswa agar admin mudah mengecek pembayaran.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Form Pemesanan Jersey -->
        <section class="bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-7 shadow-2xl mb-10">
            <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                Form Pemesanan Jersey
            </p>
            <h2 class="text-2xl font-black mb-5">Lengkapi Data Pemesanan</h2>

            <form action="{{ route('siswa.jersey.pesan') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-black/70 font-semibold mb-2">Tipe Jersey</label>
                        <select name="tipe_jersey" required class="w-full bg-[#fff3e8] border border-[#d4af37] rounded-xl p-3 text-black">
                            <option value="">-- Pilih Tipe Jersey --</option>
                            @foreach($jerseys as $jersey)
                                <option value="{{ $jersey->tipe_jersey }}">{{ $jersey->tipe_jersey }} - Rp{{ number_format($jersey->harga,0,',','.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-black/70 font-semibold mb-2">Ukuran</label>
                        <select name="ukuran" required class="w-full bg-[#fff3e8] border border-[#d4af37] rounded-xl p-3 text-black">
                            <option value="">-- Pilih Ukuran --</option>
                            @foreach(['S','M','L','XL','XXL'] as $size)
                                <option value="{{ $size }}">{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-black/70 font-semibold mb-2">Nama Punggung</label>
                        <input type="text" name="nama_punggung" placeholder="Contoh: SHERLY" class="w-full bg-[#fff3e8] border border-[#d4af37] rounded-xl p-3 text-black">
                    </div>
                    <div>
                        <label class="block text-black/70 font-semibold mb-2">Nomor Punggung</label>
                        <input type="number" name="nomor_punggung" placeholder="Contoh: 10" min="1" max="99" class="w-full bg-[#fff3e8] border border-[#d4af37] rounded-xl p-3 text-black">
                    </div>
                </div>
                <div class="mt-7">
                    <button type="submit" class="bg-[#d4af37] text-[#120608] px-8 py-3 rounded-xl font-bold hover:bg-[#e6c04a]">
                        Pesan Jersey
                    </button>
                </div>
            </form>
        </section>

        <!-- Riwayat Pesanan Jersey -->
        <section>
            <h2 class="text-2xl font-black mb-5 text-[#d4af37]">Riwayat Pesanan Jersey</h2>

            <div class="space-y-5">
                @forelse($pesananJerseys as $pesanan)
                    <div class="bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-5 shadow-2xl">
                        <p><span class="font-bold">Tipe Jersey:</span> {{ $pesanan->tipe_jersey }}</p>
                        <p><span class="font-bold">Ukuran:</span> {{ $pesanan->ukuran }}</p>
                        <p><span class="font-bold">Nama & Nomor:</span> {{ $pesanan->nama_punggung ?? '-' }} {{ $pesanan->nomor_punggung ?? '' }}</p>
                        <p><span class="font-bold">Harga:</span> Rp{{ number_format($pesanan->harga,0,',','.') }}</p>
                        <p><span class="font-bold">Status:</span> {{ $pesanan->status }}</p>

                        @if($pesanan->status === 'Dikonfirmasi Admin')
                            <form action="{{ route('siswa.jersey.upload', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                @csrf
                                <label class="block text-black/70 font-semibold mb-2">Upload Bukti Pembayaran</label>
                                <input type="file" name="bukti_pembayaran" required class="text-black/70">
                                <button type="submit" class="mt-2 bg-[#d4af37] text-[#120608] px-5 py-2 rounded-xl font-bold hover:bg-[#e6c04a]">
                                    Upload
                                </button>
                            </form>
                        @else
                            <p class="mt-2 text-yellow-700 text-sm">Menunggu konfirmasi admin sebelum upload bukti.</p>
                        @endif
                    </div>
                @empty
                    <p class="text-black/60">Belum ada pesanan jersey.</p>
                @endforelse
            </div>
        </section>

    </div>
</main>

</body>
</html>