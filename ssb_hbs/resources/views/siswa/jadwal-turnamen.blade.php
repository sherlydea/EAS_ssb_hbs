<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Turnamen - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-red-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">Jadwal Turnamen</h1>

        <a href="{{ route('siswa.dashboard') }}"
           class="bg-white text-red-700 px-4 py-2 rounded font-semibold">
            Kembali
        </a>
    </nav>

    <main class="p-6 max-w-5xl mx-auto">

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-2xl font-bold text-red-700 mb-4">
                Turnamen Yang Akan Datang
            </h2>

            <table class="w-full border">
                <thead class="bg-red-700 text-white">
                    <tr>
                        <th class="border p-3">Nama Turnamen</th>
                        <th class="border p-3">Tanggal</th>
                        <th class="border p-3">Lokasi</th>
                        <th class="border p-3">Status</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="border p-3">Liga Junior Surabaya</td>
                        <td class="border p-3">10 Juni 2026</td>
                        <td class="border p-3">Gelora 10 November</td>
                        <td class="border p-3">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                                Terdaftar
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="border p-3">Piala Walikota</td>
                        <td class="border p-3">25 Juni 2026</td>
                        <td class="border p-3">Lapangan THOR</td>
                        <td class="border p-3">
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                                Menunggu
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

    </main>

</body>
</html>