<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Jersey - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-red-700 text-white px-6 py-4 flex justify-between items-center">
    <h1 class="font-bold text-xl">Pemesanan Jersey</h1>
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
        <h2 class="text-2xl font-bold text-red-700 mb-4">Daftar Jersey</h2>

        <table class="w-full border">
            <thead class="bg-red-700 text-white">
                <tr>
                    <th class="border p-3">Tipe Jersey</th>
                    <th class="border p-3">Harga</th>
                    <th class="border p-3">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-3">Home</td>
                    <td class="border p-3">Rp120.000</td>
                    <td class="border p-3">Jersey utama SSB HBS</td>
                </tr>
                <tr>
                    <td class="border p-3">Away</td>
                    <td class="border p-3">Rp120.000</td>
                    <td class="border p-3">Jersey tandang SSB HBS</td>
                </tr>
                <tr>
                    <td class="border p-3">Training</td>
                    <td class="border p-3">Rp100.000</td>
                    <td class="border p-3">Jersey latihan siswa</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded shadow p-6">
        <h2 class="text-2xl font-bold text-red-700 mb-4">Form Pesan Jersey</h2>

        <form action="{{ route('siswa.jersey.pesan') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-2">Tipe Jersey</label>
                <select name="tipe_jersey" class="w-full border rounded p-3" required>
                    <option value="">-- Pilih Tipe Jersey --</option>
                    <option value="Home">Home - Rp120.000</option>
                    <option value="Away">Away - Rp120.000</option>
                    <option value="Training">Training - Rp100.000</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Ukuran</label>
                <select name="ukuran" class="w-full border rounded p-3" required>
                    <option value="">-- Pilih Ukuran --</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Nama Punggung</label>
                <input
                    type="text"
                    name="nama_punggung"
                    class="w-full border rounded p-3"
                    placeholder="Contoh: SHERLY"
                >
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Nomor Punggung</label>
                <input
                    type="number"
                    name="nomor_punggung"
                    class="w-full border rounded p-3"
                    placeholder="Contoh: 10"
                    min="1"
                    max="99"
                >
            </div>

            <button type="submit" class="bg-red-700 text-white px-6 py-3 rounded font-semibold hover:bg-red-800">
                Pesan Jersey
            </button>
        </form>
    </div>

</main>

</body>
</html>