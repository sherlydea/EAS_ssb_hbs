<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Absensi - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-red-700 text-white px-6 py-4 flex justify-between items-center">
    <h1 class="font-bold text-xl">Riwayat Absensi</h1>
    <a href="{{ route('siswa.dashboard') }}" class="bg-white text-red-700 px-4 py-2 rounded font-semibold">Kembali</a>
</nav>

<main class="p-6 max-w-5xl mx-auto">
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-2xl font-bold text-red-700 mb-4">Riwayat Kehadiran</h2>

        <table class="w-full border">
            <thead class="bg-red-700 text-white">
                <tr>
                    <th class="border p-3">Tanggal</th>
                    <th class="border p-3">Kehadiran</th>
                    <th class="border p-3">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-3">01-05-2026</td>
                    <td class="border p-3"><span class="bg-green-100 text-green-700 px-2 py-1 rounded">Hadir</span></td>
                    <td class="border p-3">Latihan rutin</td>
                </tr>
                <tr>
                    <td class="border p-3">03-05-2026</td>
                    <td class="border p-3"><span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Izin</span></td>
                    <td class="border p-3">Sakit</td>
                </tr>
                <tr>
                    <td class="border p-3">05-05-2026</td>
                    <td class="border p-3"><span class="bg-red-100 text-red-700 px-2 py-1 rounded">Alpa</span></td>
                    <td class="border p-3">Tidak hadir tanpa keterangan</td>
                </tr>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>