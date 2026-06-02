<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran SPP - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-red-700 text-white px-6 py-4 flex justify-between items-center">
    <h1 class="font-bold text-xl">Pembayaran SPP</h1>
    <a href="{{ route('siswa.dashboard') }}" class="bg-white text-red-700 px-4 py-2 rounded font-semibold">
        Kembali
    </a>
</nav>

<main class="p-6 max-w-5xl mx-auto">

    @if(session('success'))
        <div class="bg-green-100 text-green-700 border border-green-300 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 border border-red-300 p-4 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-2xl font-bold text-red-700 mb-4">Informasi Rekening</h2>

        <div class="bg-yellow-50 border border-yellow-300 p-4 rounded">
            <p><strong>Bank:</strong> BCA</p>
            <p><strong>No Rekening:</strong> 1234567890</p>
            <p><strong>Atas Nama:</strong> SSB HBS</p>
            <p class="text-sm text-gray-600 mt-2">
                Transfer sesuai tagihan SPP yang muncul, lalu upload bukti pembayaran.
            </p>
        </div>
    </div>

    <div class="bg-white rounded shadow p-6 mb-8">
        <h2 class="text-2xl font-bold text-red-700 mb-4">Tagihan Aktif</h2>

        @if($tagihanAktif)
            <div class="border rounded p-5 bg-gray-50 mb-5">
                <p class="mb-2">
                    <strong>Periode:</strong>
                    {{ $tagihanAktif->bulan }} {{ $tagihanAktif->tahun }}
                </p>

                <p class="mb-2">
                    <strong>Nominal:</strong>
                    Rp{{ number_format($tagihanAktif->nominal, 0, ',', '.') }}
                </p>

                <p class="mb-2">
                    <strong>Status:</strong>
                    <span class="px-3 py-1 rounded bg-red-100 text-red-700">
                        {{ $tagihanAktif->status }}
                    </span>
                </p>
            </div>

            <form action="{{ route('siswa.pembayaran.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="tagihan_spp_id" value="{{ $tagihanAktif->id }}">

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Jumlah Pembayaran</label>
                    <input
                        type="text"
                        value="Rp{{ number_format($tagihanAktif->nominal, 0, ',', '.') }}"
                        class="w-full border rounded p-3 bg-gray-100 cursor-not-allowed"
                        readonly
                    >
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Upload Bukti Transfer</label>
                    <input
                        type="file"
                        name="bukti_pembayaran"
                        class="w-full border rounded p-3"
                        required
                    >
                    <p class="text-sm text-gray-500 mt-1">
                        Format: JPG, JPEG, PNG, atau PDF. Maksimal 2MB.
                    </p>
                </div>

                <button type="submit" class="bg-red-700 text-white px-6 py-3 rounded font-semibold hover:bg-red-800">
                    Kirim Bukti Pembayaran
                </button>
            </form>
        @else
            <div class="bg-green-50 border border-green-300 text-green-700 p-5 rounded">
                Saat ini tidak ada tagihan SPP yang perlu dibayar. Silakan tunggu tagihan baru dari pihak sekolah.
            </div>
        @endif
    </div>

    <div class="bg-white rounded shadow p-6">
        <h2 class="text-2xl font-bold text-red-700 mb-4">Riwayat Pembayaran SPP</h2>

        <table class="w-full border">
            <thead class="bg-red-700 text-white">
                <tr>
                    <th class="border p-3">Periode</th>
                    <th class="border p-3">Tanggal Bayar</th>
                    <th class="border p-3">Nominal</th>
                    <th class="border p-3">Status</th>
                    <th class="border p-3">Bukti</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatSpp as $r)
                    <tr>
                        <td class="border p-3">{{ $r->bulan }} {{ $r->tahun }}</td>
                        <td class="border p-3">
                            {{ $r->tanggal_bayar ?? '-' }}
                        </td>
                        <td class="border p-3">
                            Rp{{ number_format($r->nominal, 0, ',', '.') }}
                        </td>
                        <td class="border p-3">
                            @if($r->status === 'Lunas')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded">{{ $r->status }}</span>
                            @elseif($r->status === 'Menunggu Verifikasi')
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded">{{ $r->status }}</span>
                            @elseif($r->status === 'Ditolak')
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded">{{ $r->status }}</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded">{{ $r->status }}</span>
                            @endif
                        </td>
                        <td class="border p-3">
                            @if($r->bukti_pembayaran)
                                <a
                                    href="{{ asset('uploads/bukti_pembayaran/'.$r->bukti_pembayaran) }}"
                                    target="_blank"
                                    class="text-red-700 font-semibold hover:underline"
                                >
                                    Lihat Bukti
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border p-3 text-center text-gray-500">
                            Belum ada riwayat tagihan SPP.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</main>

</body>
</html>