<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPP Saya - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f5f0e6] text-black min-h-screen">

    @include('siswa.partials.sidebar')

    @php
        $siswa = \DB::table('siswas')->where('user_id', auth()->user()->id)->first();
        $namaSiswa = $siswa->nama ?? auth()->user()->name ?? 'Siswa';
        $kategori = $siswa->kategori_latihan ?? '-';
        $rekeningBank = '1234567890';
        $atasNama = 'SSB HBS';

        function badgeSppClass($status) {
            return match ($status) {
                'Lunas' => 'bg-green-500/15 text-green-700',
                'Menunggu Verifikasi' => 'bg-yellow-500/15 text-yellow-700',
                'Ditolak' => 'bg-red-500/15 text-red-600',
                default => 'bg-white/10 text-black/60',
            };
        }
    @endphp

    <main class="pt-28 pb-16 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">

            <section class="mb-12">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3 text-sm">SPP Saya</p>
                <h1 class="text-4xl md:text-5xl font-black leading-tight">Tagihan & Riwayat SPP</h1>
                <p class="text-black/60 mt-3 max-w-2xl">Informasi tagihan aktif, upload bukti transfer, dan pantau riwayat pembayaran.</p>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">
                    @forelse($tagihanAktif as $tagihan)
                        <div class="bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-8 shadow-xl">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                                    <p class="text-black/50 text-xs uppercase font-bold mb-1">Periode</p>
                                    <p class="font-bold text-lg">{{ $tagihan->bulan }} {{ $tagihan->tahun }}</p>
                                </div>
                                <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                                    <p class="text-black/50 text-xs uppercase font-bold mb-1">Nominal</p>
                                    <p class="text-3xl font-black">Rp{{ number_format($tagihan->nominal,0,',','.') }}</p>
                                </div>
                            </div>

                            <form action="{{ route('siswa.pembayaran.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="tagihan_spp_id" value="{{ $tagihan->id }}">
                                <label class="block text-sm font-bold mb-3 uppercase tracking-wider text-[#4e1218]">Upload Bukti Transfer</label>
                                <div class="flex gap-4">
                                    <input type="file" name="bukti_pembayaran" required class="flex-1 bg-white p-3 rounded-xl border border-black/10 focus:outline-none focus:ring-2 focus:ring-[#d4af37]">
                                    <button type="submit" class="bg-[#d4af37] px-8 py-3 rounded-xl font-bold hover:bg-[#c49c2d] transition">Upload</button>
                                </div>
                            </form>
                        </div>
                    @empty
                        <div class="bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-8 text-center">
                            <p class="font-bold text-black/60">Tidak ada tagihan aktif saat ini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-8 h-fit shadow-lg">
                    <p class="font-bold uppercase tracking-widest text-[#d4af37] text-sm mb-6">Ringkasan Data</p>
                    <div class="space-y-5">
                        <div class="border-b border-black/10 pb-4">
                            <p class="text-black/50 text-xs uppercase font-bold mb-1">Nama Siswa</p>
                            <p class="font-bold text-lg">{{ $namaSiswa }}</p>
                        </div>
                        <div class="border-b border-black/10 pb-4">
                            <p class="text-black/50 text-xs uppercase font-bold mb-1">Kategori</p>
                            <p class="font-bold text-lg text-[#d4af37]">{{ $kategori }}</p>
                        </div>
                        <div>
                            <p class="text-black/50 text-xs uppercase font-bold mb-1">Info Rekening</p>
                            <p class="font-bold text-lg">{{ $rekeningBank }}</p>
                            <p class="text-sm text-black/60">{{ $atasNama }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mt-12 bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-8 shadow-xl">
                <h2 class="text-2xl font-black mb-6">Riwayat Pembayaran</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-[#4e1218]/5">
                            <tr>
                                <th class="p-4 text-xs uppercase tracking-wider">Periode</th>
                                <th class="p-4 text-xs uppercase tracking-wider">Nominal</th>
                                <th class="p-4 text-xs uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-black/10">
                            @foreach($riwayatSpp as $item)
                            <tr>
                                <td class="p-4 font-bold">{{ $item->bulan }} {{ $item->tahun }}</td>
                                <td class="p-4 font-medium">Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    <span class="{{ badgeSppClass($item->status) }} px-4 py-1.5 rounded-full text-xs font-bold">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>
</html>