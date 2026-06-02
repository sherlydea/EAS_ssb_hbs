<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pembayaran SPP - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-red-700 text-white px-6 py-4 flex justify-between items-center">
    <h1 class="font-bold text-xl">Riwayat Pembayaran SPP</h1>
    <a href="{{ route('siswa.dashboard') }}" class="bg-white text-red-700 px-4 py-2 rounded font-semibold">
        Kembali
    </a>
</nav>

<main class="p-6 max-w-5xl mx-auto">
    <div class="bg-white rounded shadow p-6 mb-6">
        <table class="w-full border">
            <thead class="bg-red-700 text-white">
                <tr>
                    <th class="border p-3">Tanggal</th>
                    <th class="border p-3">Jenis Pembayaran</th>
                    <th class="border p-3">Jumlah</th>
                    <th class="border p-3">Status</th>
                    <th class="border p-3">Bukti</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembayarans as $p)
                    <tr>
                        <td class="border p-3">{{ $p->tanggal_bayar }}</td>
                        <td class="border p-3">{{ $p->nama_pembayaran }}</td>
                        <td class="border p-3">Rp{{ number_format($p->jumlah,0,',','.') }}</td>
                        <td class="border p-3">{{ $p->status }}</td>
                        <td class="border p-3">
                            @if($p->bukti_pembayaran)
                                <a href="{{ asset('uploads/bukti_pembayaran/'.$p->bukti_pembayaran) }}" target="_blank">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

</body>
</html>