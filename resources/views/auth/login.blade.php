<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SSB HBS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html,body{
            min-height:100%;
            overflow-y:auto;
        }

        .glass-card{
            background:linear-gradient(
                145deg,
                rgba(116,18,37,.92),
                rgba(76,8,25,.92)
            );
            backdrop-filter:blur(18px);
            border:1px solid rgba(212,175,55,.20);
            box-shadow:
                0 25px 60px rgba(0,0,0,.40),
                0 0 40px rgba(212,175,55,.08);
        }

        .input-custom{
            background:rgba(255,255,255,.08);
            border:1px solid rgba(212,175,55,.25);
            color:white;
        }

        .input-custom::placeholder{
            color:rgba(255,255,255,.55);
        }

        .input-custom:focus{
            border-color:#d4af37;
            box-shadow:0 0 0 3px rgba(212,175,55,.15);
            outline:none;
        }
    </style>
</head>

<body class="bg-[#1a0006] min-h-screen flex items-center justify-center px-4 relative overflow-hidden">

    <!-- Bubble Background -->
    <div class="absolute top-20 left-20 w-80 h-80 bg-[#d4af37]/10 blur-3xl rounded-full"></div>
    <div class="absolute bottom-20 right-20 w-80 h-80 bg-[#7a1025]/30 blur-3xl rounded-full"></div>

    <div class="relative z-10 w-full max-w-md">

        <!-- Logo -->
        <div class="text-center mb-8">
            <h1 class="text-5xl font-black text-white">
                SSB <span class="text-[#d4af37]">HBS</span>
            </h1>

            <p class="text-white/60 mt-2">
                Sistem Informasi Sekolah Sepak Bola
            </p>
        </div>

        <!-- Card -->
        <div class="glass-card rounded-3xl p-8">

            <h2 class="text-3xl font-black text-[#d4af37] text-center mb-2">
                Login
            </h2>

            <p class="text-white/70 text-center mb-6">
                Masuk ke akun siswa, pelatih, atau admin
            </p>

            @if($errors->any())
                <div class="bg-red-500/15 border border-red-500/30 text-red-200 p-4 rounded-2xl mb-5">
                    {{ $errors->first() }}
                </div>
            @endif

            <form
                id="loginForm"
                action="{{ route('login.process') }}"
                method="POST"
                novalidate
            >
                @csrf

                <!-- Username -->
                <div class="mb-5">
                    <label class="block mb-2 text-white font-medium">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        value="{{ old('username', Cookie::get('remember_username')) }}"
                        placeholder="Masukkan username"
                        class="input-custom w-full rounded-xl p-3"
                    >
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label class="block mb-2 text-white font-medium">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Masukkan password"
                        class="input-custom w-full rounded-xl p-3"
                    >
                </div>

                <!-- Remember -->
                <div class="flex items-center justify-between mb-6">

                    <label class="flex items-center text-white/80">
                        <input
                            type="checkbox"
                            name="remember"
                            class="mr-2"
                            {{ Cookie::has('remember_username') ? 'checked' : '' }}
                        >
                        Remember Me
                    </label>

                    <button
                        type="button"
                        onclick="togglePassword()"
                        class="text-[#d4af37] hover:underline text-sm"
                    >
                        Lihat Password
                    </button>

                </div>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full bg-[#d4af37] text-[#2b0910] py-3 rounded-xl font-black hover:bg-[#e3bf47] transition shadow-lg"
                >
                    Login
                </button>

            </form>

            <p class="text-center mt-6 text-white/70">
                Belum punya akun?

                <a
                    href="{{ route('pendaftaran.create') }}"
                    class="text-[#d4af37] font-bold hover:underline"
                >
                    Daftar
                </a>
            </p>

            <div class="text-center mt-4">
                <a
                    href="{{ route('home') }}"
                    class="text-white/50 hover:text-[#d4af37] text-sm"
                >
                    Kembali ke Beranda
                </a>
            </div>

        </div>

    </div>

    <!-- POPUP VALIDASI -->
    <div
        id="validasiPopup"
        class="hidden fixed inset-0 bg-black/70 z-50 items-center justify-center px-4"
    >
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl text-center">

            <div class="text-5xl mb-3">
                ⚠️
            </div>

            <h3 class="text-2xl font-black text-[#7a1025] mb-2">
                Data Belum Lengkap
            </h3>

            <p
                id="validasiPesan"
                class="text-gray-600 mb-6"
            >
                Mohon lengkapi data terlebih dahulu.
            </p>

            <button
                onclick="tutupValidasiPopup()"
                class="bg-[#7a1025] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#600018]"
            >
                Mengerti
            </button>

        </div>
    </div>

<script>

function togglePassword(){
    const input = document.getElementById('password');
    input.type = input.type === 'password'
        ? 'text'
        : 'password';
}

const loginForm = document.getElementById('loginForm');
const popup = document.getElementById('validasiPopup');
const pesan = document.getElementById('validasiPesan');

loginForm.addEventListener('submit', function(e){

    const username =
        document.querySelector('input[name="username"]');

    const password =
        document.querySelector('input[name="password"]');

    if(username.value.trim() === ''){
        e.preventDefault();

        pesan.innerText =
            'Username wajib diisi terlebih dahulu.';

        popup.classList.remove('hidden');
        popup.classList.add('flex');

        username.focus();
        return;
    }

    if(password.value.trim() === ''){
        e.preventDefault();

        pesan.innerText =
            'Password wajib diisi terlebih dahulu.';

        popup.classList.remove('hidden');
        popup.classList.add('flex');

        password.focus();
        return;
    }

});

function tutupValidasiPopup(){
    popup.classList.add('hidden');
    popup.classList.remove('flex');
}

</script>

</body>
</html>