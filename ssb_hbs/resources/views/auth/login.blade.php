<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - SSB HBS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-red-700">Login SSB HBS</h1>
            <p class="text-gray-600 mt-2">Masuk ke akun siswa, pelatih, atau admin</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Email / Username</label>
                <input
                    type="text"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                    placeholder="Masukkan email atau username"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <div class="mb-4 flex items-center justify-between">
                <label class="flex items-center text-gray-700">
                    <input type="checkbox" name="remember" class="mr-2">
                    Remember Me
                </label>

                <button type="button" onclick="togglePassword()" class="text-sm text-red-600 hover:underline">
                    Lihat Password
                </button>
            </div>

            <button
                type="submit"
                class="w-full bg-red-600 text-white py-3 rounded hover:bg-red-700 font-semibold transition"
            >
                Login
            </button>
        </form>

        <p class="text-center mt-5 text-gray-600">
            Belum punya akun?
            <a href="{{ route('pendaftaran.create') }}" class="text-red-600 font-semibold hover:underline">
                Daftar
            </a>
        </p>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-red-600 text-sm">
                Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>

</body>
</html>