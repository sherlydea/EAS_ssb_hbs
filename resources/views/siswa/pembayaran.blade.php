<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPP Saya - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f5f0e6] text-black min-h-screen overflow-x-hidden px-6 py-10">

    @include('siswa.partials.sidebar')

    @php
        $siswa = \DB::table('siswas')
            ->where('user_id', auth()->user()->id)
            ->first();

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

    <main class="pt-28 min-h-screen">
        <div class="max-w-7xl mx-auto">

            <!-- Header -->
            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    SPP Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Tagihan & Riwayat SPP
                </h1>

                <p class="text-black/60 mt-3 max-w-2xl">
                    Informasi tagihan aktif, upload bukti transfer, dan pantau riwayat pembayaran.
                </p>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Tagihan Aktif -->
                <div class="lg:col-span-2 bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    @if($tagihanAktif)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                            <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                                <p class="text-black/50 text-sm mb-1">Nama Siswa</p>
                                <p class="font-bold">{{ $namaSiswa }}</p>
                            </div>

                            <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                                <p class="text-black/50 text-sm mb-1">Kategori</p>
                                <p class="font-bold text-[#d4af37]">{{ $kategori }}</p>
                            </div>

                            <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                                <p class="text-black/50 text-sm mb-1">Periode</p>
                                <p class="font-bold">{{ $tagihanAktif->bulan }} {{ $tagihanAktif->tahun }}</p>
                            </div>

                            <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                                <p class="text-black/50 text-sm mb-1">Nominal Tagihan</p>
                                <p class="text-3xl font-black">Rp{{ number_format($tagihanAktif->nominal,0,',','.') }}</p>
                            </div>

                            <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                                <p class="text-black/50 text-sm mb-1">No. Rek / Atas Nama</p>
                                <p class="font-bold">{{ $rekeningBank }} / {{ $atasNama }}</p>
                            </div>

                            <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                                <p class="text-black/50 text-sm mb-1">Tanggal Bayar / Upload</p>
                                <p class="font-bold">
                                    {{ $tagihanAktif->tanggal_bayar ? \Carbon\Carbon::parse($tagihanAktif->tanggal_bayar)->format('d M Y H:i') : '-' }}
                                </p>
                            </div>

                            <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                                <p class="text-black/50 text-sm mb-1">Bukti Pembayaran</p>
                                @if($tagihanAktif->bukti_pembayaran)
                                    <a href="{{ asset('uploads/bukti_pembayaran/' . $tagihanAktif->bukti_pembayaran) }}"
                                       target="_blank"
                                       class="text-[#d4af37] font-bold hover:underline">
                                        Lihat Bukti
                                    </a>
                                @else
                                    <p class="font-bold">Belum upload</p>
                                @endif
                            </div>
                        </div>

                        @if(in_array($tagihanAktif->status, ['Belum Bayar','Ditolak']))
                            <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5 mb-6">
                                <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                                    Upload Bukti Pembayaran
                                </p>

                                <form action="{{ route('siswa.pembayaran.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="tagihan_spp_id" value="{{ $tagihanAktif->id }}">

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                        <div class="md:col-span-2">
                                            <label class="block text-black/60 text-sm mb-2">
                                                Pilih file bukti transfer
                                            </label>

                                            <input type="file"
                                                name="bukti_pembayaran"
                                                class="w-full bg-[#fff3e8] border border-[#d4af37] rounded-xl p-3 text-black
                                                file:bg-[#d4af37] file:text-[#120608] file:border-0 file:px-4 file:py-2 file:rounded-lg file:font-bold"
                                                required
                                            >
                                        </div>

                                        <button type="submit"
                                            class="w-full bg-[#d4af37] text-[#120608] py-3 rounded-xl font-bold hover:bg-[#e6c04a] transition">
                                            Upload Bukti
                                        </button>
                                    </div>
                                </form>

                                <p class="text-black/60 text-sm mt-4 leading-relaxed">
                                    Setelah bukti dikirim, status akan menjadi
                                    <span class="text-yellow-700 font-bold">Menunggu Verifikasi</span>
                                    sampai admin melakukan pengecekan.
                                </p>
                            </div>
                        @endif

                    @else
                        <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-6">
                            <p class="text-black/60 font-bold mb-2">
                                Belum ada tagihan aktif.
                            </p>
                            <p class="text-black/50 text-sm leading-relaxed">
                                Tagihan SPP akan muncul setelah admin membuat tagihan.
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Ringkasan -->
                <div class="bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                        Ringkasan
                    </p>

                    <div class="space-y-4">
                        <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                            <p class="text-black/50 text-sm mb-1">Nama Siswa</p>
                            <p class="font-bold">{{ $namaSiswa }}</p>
                        </div>

                        <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                            <p class="text-black/50 text-sm mb-1">Kategori</p>
                            <p class="font-bold text-[#d4af37]">{{ $kategori }}</p>
                        </div>

                        <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                            <p class="text-black/50 text-sm mb-1">Tagihan Aktif</p>
                            <p class="font-bold">
                                {{ $tagihanAktif ? $tagihanAktif->bulan . ' ' . $tagihanAktif->tahun : 'Tidak Ada' }}
                            </p>
                        </div>

                        <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                            <p class="text-black/50 text-sm mb-1">Status</p>
                            <p class="font-bold {{ $tagihanAktif && $tagihanAktif->status === 'Lunas' ? 'text-green-700' : ($tagihanAktif && $tagihanAktif->status === 'Ditolak' ? 'text-red-600' : 'text-yellow-700') }}">
                                {{ $tagihanAktif ? $tagihanAktif->status : 'Aman' }}
                            </p>
                        </div>

                        <div class="bg-[#fff3e8] border border-[#d4af37]/30 rounded-2xl p-5">
                            <p class="text-black/50 text-sm mb-1">No. Rek / Atas Nama</p>
                            <p class="font-bold">{{ $rekeningBank }} / {{ $atasNama }}</p>
                        </div>
                    </div>
                </div>

            </section>

            <!-- Riwayat SPP -->
            <section class="mt-6 bg-[#fff8f0] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                            Riwayat SPP
                        </p>

                        <h2 class="text-2xl font-black">
                            Riwayat Tagihan dan Pembayaran
                        </h2>
                    </div>

                    <span class="w-fit bg-[#d4af37]/15 text-[#d4af37] px-4 py-2 rounded-full text-sm font-bold">
                        {{ $riwayatSpp->count() }} Data
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] text-left">
                        <thead class="bg-[#8d001f]/20">
                            <tr>
                                <th class="py-4 px-4">Periode</th>
                                <th class="py-4 px-4">Nominal</th>
                                <th class="py-4 px-4">Tanggal Bayar</th>
                                <th class="py-4 px-4">Bukti</th>
                                <th class="py-4 px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#4e1218]/20">
                            @forelse($riwayatSpp as $item)
                                <tr class="hover:bg-[#1a0608] transition">
                                    <td class="py-4 px-4 font-bold">
                                        {{ $item->bulan }} {{ $item->tahun }}
                                    </td>

                                    <td class="py-4 px-4 text-black/70">
                                        Rp{{ number_format($item->nominal, 0, ',', '.') }}
                                    </td>

                                    <td class="py-4 px-4 text-black/70">
                                        {{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y H:i') : '-' }}
                                    </td>

                                    <td class="py-4 px-4">
                                        @if($item->bukti_pembayaran)
                                            <a
                                                href="{{ asset('uploads/bukti_pembayaran/' . $item->bukti_pembayaran) }}"
                                                target="_blank"
                                                class="text-[#d4af37] font-bold hover:underline"
                                            >
                                                Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-black/45">-</span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-4">
                                        <span class="{{ badgeSppClass($item->status) }} px-3 py-1.5 rounded-full text-xs font-bold">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 px-4 text-center text-black/50">
                                        Belum ada riwayat SPP.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>

</body>
</html>