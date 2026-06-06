<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Siswa SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-10 rounded shadow w-full max-w-lg">
        <h2 class="text-2xl font-bold text-red-700 mb-6 text-center">Form Pendaftaran Siswa</h2>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('pendaftaran.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-semibold" for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold" for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold" for="password">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Daftar
            </button>
        </form>

        <p class="mt-4 text-center text-sm">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-red-600 hover:underline">Login di sini</a>
        </p>
    </div>

</body>
</html>