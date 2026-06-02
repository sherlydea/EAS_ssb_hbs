<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Latihan - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-red-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">Jadwal Latihan</h1>

        <a href="{{ route('siswa.dashboard') }}"
           class="bg-white text-red-700 px-4 py-2 rounded font-semibold">
            Kembali
        </a>
    </nav>

    <main class="p-6 max-w-5xl mx-auto">

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-2xl font-bold text-red-700 mb-4">
                Jadwal Latihan Mingguan
            </h2>

            <table class="w-full border">
                <thead class="bg-red-700 text-white">
                    <tr>
                        <th class="border p-3">Hari</th>
                        <th class="border p-3">Jam</th>
                        <th class="border p-3">Kategori</th>
                        <th class="border p-3">Lokasi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="border p-3">Senin</td>
                        <td class="border p-3">15.30 - 17.00</td>
                        <td class="border p-3">U-10</td>
                        <td class="border p-3">Lapangan HBS</td>
                    </tr>

                    <tr>
                        <td class="border p-3">Rabu</td>
                        <td class="border p-3">15.30 - 17.00</td>
                        <td class="border p-3">U-12</td>
                        <td class="border p-3">Lapangan HBS</td>
                    </tr>

                    <tr>
                        <td class="border p-3">Jumat</td>
                        <td class="border p-3">15.30 - 17.00</td>
                        <td class="border p-3">U-15</td>
                        <td class="border p-3">Lapangan HBS</td>
                    </tr>
                </tbody>
            </table>

        </div>

    </main>

</body>
</html>