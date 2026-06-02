<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

@include('siswa.partials.sidebar')

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold text-red-700">SSB HBS</h1>
    <button onclick="toggleSidebar()" class="text-red-700 text-3xl font-bold">☰</button>
</nav>

<main class="min-h-[80vh] flex items-center justify-center px-6">
    <div class="bg-white rounded shadow p-10 max-w-3xl text-center">
        <h2 class="text-3xl font-bold text-red-700 mb-4">
            Selamat Datang, {{ auth()->user()->name }}
        </h2>
        <p class="text-gray-600 text-lg leading-relaxed">
            Selamat datang di Sistem Informasi SSB HBS. Silakan gunakan menu di pojok kanan atas untuk mengakses layanan siswa.
        </p>
    </div>
</main>

</body>
</html>