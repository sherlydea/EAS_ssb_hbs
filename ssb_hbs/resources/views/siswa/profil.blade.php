<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Siswa - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-red-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-xl">Profil Siswa</h1>
        <a href="{{ route('siswa.dashboard') }}" class="bg-white text-red-700 px-4 py-2 rounded font-semibold">
            Kembali
        </a>
    </nav>

    <main class="p-6 max-w-4xl mx-auto">
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-2xl font-bold text-red-700 mb-4">Data Profil</h2>

            <table class="w-full border">
                <tr>
                    <td class="border p-3 font-semibold w-1/3">Nama</td>
                    <td class="border p-3">{{ auth()->user()->name }}</td>
                </tr>
                <tr>
                    <td class="border p-3 font-semibold">Email</td>
                    <td class="border p-3">{{ auth()->user()->email }}</td>
                </tr>
                <tr>
                    <td class="border p-3 font-semibold">Role</td>
                    <td class="border p-3">{{ ucfirst(auth()->user()->role) }}</td>
                </tr>
                <tr>
                    <td class="border p-3 font-semibold">Status</td>
                    <td class="border p-3">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm">
                            Aktif
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </main>

</body>
</html>